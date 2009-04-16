<?php
require_once 'PHPUnit/Framework.php';
require_once '../sap_config.php';
global $SAP_CONFIG, $SAPNWRFC_LOADED; 

class FuncDescTest extends PHPUnit_Framework_TestCase
{

    protected function setUp() {
        global $SAPNWRFC_LOADED, $SAP_CONFIG;
        if (empty($SAPNWRFC_LOADED)) {
            dl("sapnwrfc.so");
            $SAPNWRFC_LOADED = true;
        }
        $yaml = file_get_contents($SAP_CONFIG);
        $this->config = syck_load($yaml);
        echo "sapnwrfc version: ".sapnwrfc_version()."\n";
        echo "nw rfc sdk version: ".sapnwrfc_rfcversion()."\n";
    }
    
    public function testFuncDesc1() {
       try {
            $conn = new sapnwrfc($this->config);
            // we must have a valid connection
            $this->assertNotNull($conn);
            $func = $conn->function_lookup("RFC_READ_REPORT");
            $this->assertEquals($func->name, "RFC_READ_REPORT");
        }
        catch (Exception $e) {
            echo "Exception message: ".$e->getMessage();
            throw new Exception('Assertion failed.');
        }
    }
    
    public function testFuncDesc2() {
       try {
            foreach (array("STFC_CHANGING", "STFC_XSTRING", "RFC_READ_TABLE", "RFC_READ_REPORT", "RPY_PROGRAM_READ", "RFC_PING", "RFC_SYSTEM_INFO") as $i) {
                $conn = new sapnwrfc($this->config);
                // we must have a valid connection
                $this->assertNotNull($conn);
                $func = $conn->function_lookup($i);
                $this->assertEquals($func->name, $i);
            }
        }
        catch (Exception $e) {
            echo "Exception message: ".$e->getMessage();
            throw new Exception('Assertion failed.');
        }
    }
    
    public function testFuncDesc3() {
       try {
            $conn = new sapnwrfc($this->config);
            // we must have a valid connection
            $this->assertNotNull($conn);
            foreach (array("STFC_CHANGING", "STFC_XSTRING", "RFC_READ_TABLE", "RFC_READ_REPORT", "RPY_PROGRAM_READ", "RFC_PING", "RFC_SYSTEM_INFO") as $f) {
                $func = $conn->function_lookup($f);
                $this->assertEquals($func->name, $f);
            }
        }
        catch (Exception $e) {
            echo "Exception message: ".$e->getMessage();
            throw new Exception('Assertion failed.');
        }
    }
    
    public function testFuncDesc4() {
       try {
            $conn = new sapnwrfc($this->config);
            // we must have a valid connection
            $this->assertNotNull($conn);
            for ($i=0; $i<100; $i++) {
            //echo "iter: $i\n";
                foreach (array("STFC_CHANGING", "STFC_XSTRING", "RFC_READ_TABLE", "RFC_READ_REPORT", "RPY_PROGRAM_READ", "RFC_PING", "RFC_SYSTEM_INFO") as $f) {
                    $func = $conn->function_lookup($f);
                    $this->assertEquals($func->name, $f);
                }
            }
        }
        catch (Exception $e) {
            echo "Exception message: ".$e->getMessage();
            throw new Exception('Assertion failed.');
        }
    }
}