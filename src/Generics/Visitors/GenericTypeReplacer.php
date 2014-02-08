<?php

namespace Generics\Visitors;

class GenericTypeReplacer extends \PHPParser_NodeVisitorAbstract {
    private $ShouldBeName = false;
    private $GenericTypeMap;
    public function __construct(array $GenericTypeMap = array()) {
        $this->GenericTypeMap = $GenericTypeMap;
    }
    
    public function SetGenericTypeMap(array $GenericTypeMap) {
        $this->GenericTypeMap = $GenericTypeMap;
    }
    
    public function enterNode(\PHPParser_Node $Node) {
        switch (true) {
            case $Node instanceof \PHPParser_Node_Param:
                $TypeHint = $Node->type;
                if($TypeHint !== null) {
                    $TypeHint = (string)$TypeHint;
                    if(isset($this->GenericTypeMap[$TypeHint])) {
                        $Node->type = new \PHPParser_Node_Name_FullyQualified($this->GenericTypeMap[$TypeHint]);
                    }
                }
                return $Node;
                
            case $Node instanceof \PHPParser_Node_Expr_ClassConstFetch:
            case $Node instanceof \PHPParser_Node_Expr_StaticCall:
            case $Node instanceof \PHPParser_Node_Expr_StaticPropertyFetch:
            case $Node instanceof \PHPParser_Node_Expr_Instanceof:
                $Class = $Node->class;
                if($Class instanceof \PHPParser_Node_Name) {
                    $Name = (string)$Class;
                    if(isset($this->GenericTypeMap[$Name])) {
                        $Node->class = new \PHPParser_Node_Name_FullyQualified($this->GenericTypeMap[$Name]);
                    }
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
}