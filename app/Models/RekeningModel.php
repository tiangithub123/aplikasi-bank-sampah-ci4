<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table = "rekening";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_nasabah', 'nama_bank', 'no_rekening', 'atas_nama'];
    protected $column_order = [null, 'id_nasabah', 'nama_bank', 'no_rekening', 'atas_nama', null];
    protected $column_search = ['id_nasabah', 'nama_bank', 'no_rekening', 'atas_nama'];
    protected $order = ['id' => 'desc'];
    protected $request;
    protected $db;
    protected $dt;
    protected $session;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db      = db_connect();
        $this->request = $request;
        $this->session = \Config\Services::session();
        $id_nasabah    = $this->session->get('id');

        $this->dt      = $this->db->table($this->table);
        $this->dt      = $this->db->table($this->table)->select('rekening.id, nasabah.nama_nasabah, nama_bank, no_rekening, atas_nama')
            ->join('nasabah', 'nasabah.id = rekening.id_nasabah', 'left')
            ->where('id_nasabah', $id_nasabah);
    }

    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
