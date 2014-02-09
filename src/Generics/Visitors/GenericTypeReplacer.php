<?php

namespace Generics\Visitors;

class GenericTypeReplacer extends \PHPParser_NodeVisitorAbstract {
    private $GenericTypeMap;
    public function __construct(array $GenericTypeMap = array()) {
        $this->GenericTypeMap = $GenericTypeMap;
    }
    
    public function SetGenericTypeMap(array $GenericTypeMap) {
        $this->GenericTypeMap = $GenericTypeMap;
    }
    
    public function enterNode(\PHPParser_Node $Node) {
        switch (true) {
            case $Node instanceof \PHPParser_Node_Stmt_Class:
                if($Node->extends !== null) {
                    $this->ReplaceGenericWithConcreteType($Node->extends);
                }
                $this->ReplaceAllGenericsWithConcreteTypes($Node->implements);
                break;
                
            case $Node instanceof \PHPParser_Node_Stmt_Interface:
                $this->ReplaceAllGenericsWithConcreteTypes($Node->extends);
                break;
                
                
            case $Node instanceof \PHPParser_Node_Stmt_TraitUse:
                $this->ReplaceAllGenericsWithConcreteTypes($Node->traits);
                break;
                
            case $Node instanceof \PHPParser_Node_Param:
                if($Node->type !== null) {
                    $this->ReplaceGenericWithConcreteType($Node->type);
                }
                return $Node;
                
            case $Node instanceof \PHPParser_Node_Expr_ClassConstFetch:
            case $Node instanceof \PHPParser_Node_Expr_StaticCall:
            case $Node instanceof \PHPParser_Node_Expr_StaticPropertyFetch:
            case $Node instanceof \PHPParser_Node_Expr_Instanceof:
                if($Node->class instanceof \PHPParser_Node_Name) {
                    $this->ReplaceGenericWithConcreteType($Node->class);
                }
                return $Node;
            
            case $Node instanceof \PHPParser_Node_Name:
                $Name = (string)$Node;
                if(isset($this->GenericTypeMap[$Name])) {
                    return new \PHPParser_Node_Scalar_String($this->GenericTypeMap[$Name]);
                }
                break;
                
            default:
                return;
        }
    }
    
    private function ReplaceAllGenericsWithConcreteTypes(array &$Nodes) {
        foreach ($Nodes as &$Node) {
            $this->ReplaceGenericWithConcreteType($Node);
        }
    }
    private function ReplaceGenericWithConcreteType(&$Node) {
        $Type = (string)$Node;
        if(isset($this->GenericTypeMap[$Type])) {
            $Node = new \PHPParser_Node_Name_FullyQualified($this->GenericTypeMap[$Type]);
        }
    }
}