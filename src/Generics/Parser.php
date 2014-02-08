<?php

namespace Generics;

class Parser {
    const TypeSeperator = '_';
    
    private $PHPParser;
    private $FullyQualifyTraverser;
    private $GenericTypeReplacerTraverser;
    private $GenericTypeReplacerVisitor;
    private $PrettyPrinter;
    
    public function __construct() {
        $this->PHPParser = new \PHPParser_Parser(new \PHPParser_Lexer());
        $this->FullyQualifyTraverser = new \PHPParser_NodeTraverser();
        $this->FullyQualifyTraverser->addVisitor(new \PHPParser_NodeVisitor_NameResolver());
        $this->PrettyPrinter = new \PHPParser_PrettyPrinter_Default();
        $this->GenericTypeReplacerTraverser = new \PHPParser_NodeTraverser();
        $this->GenericTypeReplacerVisitor = new Visitors\GenericTypeReplacer();
        $this->GenericTypeReplacerTraverser->addVisitor($this->GenericTypeReplacerVisitor);
    }
    
    
    public function Parse($GenericCode, $GenericType, $GenericTypesString) {
        if(strpos('\\', $GenericType) === 0) {
            $GenericType = substr($GenericType, 1);
        }
        
        $AST = $this->PHPParser->parse($GenericCode);
        
        $ClassOrInterface = $this->GetMatchedClassOrInterface($AST, $GenericType);
        if($ClassOrInterface === null) {
            throw new \ErrorException(
                    sprintf('Failure to parse generic type %s from file', $GenericType));
        }
        
        $GenericTypes = $this->ParseGenericTypes($GenericTypesString);
        $GenericTypeMap = $this->CreateGenericTypeMap($GenericTypes);
        
        $ConcreteClassOrInterface = $this->ReplaceGenericTypes($ClassOrInterface, $GenericTypeMap);
        
        list($Namespace, $ConcreteName) = $this->CreateConcreteClassTypeName($GenericType, $GenericTypes);
        $ConcreteClassOrInterface->name = $ConcreteName;
        
        $ConcreteAST = [$this->CreateNamespaceNode($Namespace, [$ConcreteClassOrInterface])];
        
        $ConcreteCode = $this->ASTToCode($ConcreteAST);
        return $ConcreteCode;
    }
    
    private function GetMatchedClassOrInterface(array $AST, $GenericType, $Namespace = null) {
        foreach($AST as $Node) {
            if($Node instanceof \PHPParser_Node_Stmt_Namespace) {
                $Namespace = $Node->name !== null ? (string)$Node->name : null;
                return $this->GetMatchedClassOrInterface($Node->stmts, $GenericType, $Namespace);
            }
            else if($Node instanceof \PHPParser_Node_Stmt_Class ||
                    $Node instanceof \PHPParser_Node_Stmt_Interface ||
                    $Node instanceof \PHPParser_Node_Stmt_Trait) {
                $FullName = $Namespace !== null ? $Namespace . '\\' . $Node->name : $Node->name;
                if($FullName === $GenericType) {
                    return $Node;
                }
            }
        }
        return null;
    }
    
    private function ParseGenericTypes($GenericTypesString) {
        if(strpos($GenericTypesString, '\\') === 0) {
            $GenericTypesString = substr($GenericTypesString, 1);
        }
        $NamespaceSegments = explode('\\', $GenericTypesString);
        $Types = array();
        $TypeParts = array();
        foreach($NamespaceSegments as $NamespaceSegment) {
            if($NamespaceSegment === self::TypeSeperator) {
                $Types[] = implode('\\', $TypeParts);
                $TypeParts = array();
            }
            else {
                $TypeParts[] = $NamespaceSegment;
            }
        }
        $Types[] = implode('\\', $TypeParts);
        
        return $Types;
    }
    
    private function CreateGenericTypeMap(array $GenericTypes) {
        if(count($GenericTypes) === 0) {
            return array();
        }
        $GenericMap = array();
        
        $GenericMap['__TYPE__'] = $GenericTypes[0];
        $Count = 1;
        foreach ($GenericTypes as $Type) {
            $GenericMap['__TYPE' . $Count . '__'] = $Type;
            $Count++;
        }
        
        return $GenericMap;
    }
    
    private function CreateConcreteClassTypeName($GenericType, array $GenericTypes) {
        $ConcreteTypeName = str_replace('\\\\', '\\', $GenericType . '\\' . implode('\\' . self::TypeSeperator . '\\', $GenericTypes));
        $Namespace = substr($ConcreteTypeName, 0, strrpos($ConcreteTypeName, '\\'));
        $ClassName = substr($ConcreteTypeName, strrpos($ConcreteTypeName, '\\') + 1);
        
        return [$Namespace, $ClassName];
    }
    
    private function CreateNamespaceNode($Namspace, array $StatementNodes) {
        return new \PHPParser_Node_Stmt_Namespace(
                new \PHPParser_Node_Name($Namspace),
                $StatementNodes);
    }
    
    private function FullyQualify(array $AST) {
        return $this->FullyQualifyTraverser->traverse($AST);
    }
    
    private function ReplaceGenericTypes(\PHPParser_Node $ClassOrInterface, array $GenericTypeMap) {
        $this->GenericTypeReplacerVisitor->SetGenericTypeMap($GenericTypeMap);
        return $this->GenericTypeReplacerTraverser->traverse([$ClassOrInterface])[0];
    }
    
    private function ASTToCode(array $AST) {
        return $this->PrettyPrinter->prettyPrintFile($AST);
    }
}