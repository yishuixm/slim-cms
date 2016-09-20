<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/17
 * Time: 13:59
 */

namespace Common\Model;


class Model
{
    private $db;
    private $table_name;
    private $_debug = false;

    function __construct(\medoo $db, $table_name, $debug=false)
    {
        $this->db = $db;
        $this->table_name = $table_name;
        $this->_debug = $debug;
    }

    public function Model(\medoo $db, $table_name, $debug=false)
    {
        $this->__construct($db, $table_name, $debug);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    function add($row)
    {
        $rs['result'] = $this->db->insert($this->table_name, $row);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function delete($where=[])
    {
        $rs['result'] = $this->db->delete($this->table_name, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function update($set,$where=[])
    {
        $rs['result'] = $this->db->update($this->table_name, $set, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function select($where=[],$field="*")
    {
        $rs['result'] = $this->db->select($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function detail($where=[],$field="*")
    {
        $rs['result'] = $this->db->get($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function count($where=[])
    {
        $rs['result'] = $this->db->count($this->table_name, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function max($field, $where=[])
    {
        $rs['result'] = $this->db->max($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function min($field, $where=[])
    {
        $rs['result'] = $this->db->max($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function agv($field, $where=[])
    {
        $rs['result'] = $this->db->agv($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }

    function sum($field, $where=[])
    {
        $rs['result'] = $this->db->sum($this->table_name, $field, $where);
        if($this->_debug){
            $rs['_sql'] = $this->db->last_query();
        }
        return $rs;
    }
}