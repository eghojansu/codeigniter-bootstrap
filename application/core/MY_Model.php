<?php

/**
 * Extends core model common functions
 */
class MY_Model extends CI_Model
{
    /**
     * Table name
     * @var string
     */
    protected $table;

    /**
     * Primary key name
     * @var string
     */
    protected $key = 'id';

    /**
     * Prepare model
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = $this->getTable();
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTable()
    {
        if (!$this->table) {
            $namespace = ltrim(get_called_class(), '\\');
            $classname = false===strpos($namespace, '\\')?$namespace:substr(strrchr($namespace, '\\'), 1);
            $tablename = preg_replace('/([A-Z])/', '_$1', lcfirst($classname));

            $this->table = $tablename;
        }

        return $this->table;
    }

    /**
     * Transform records in table to assocative array
     *
     * @param  string     $key
     * @param  array|null $columns
     * @param  array|null $filter
     * @param  array|null $options
     * @return array
     */
    public function fetchAssoc($key, array $columns = null, array $filter = null, array $options = null)
    {
        $columns = (array) $columns;

        if (empty($columns)) {
            $columns[] = $key;
        }

        $onlyOne = 1 === count($columns);
        $firstKey = reset($columns);
        $all = $this->findAll($filter, $options);
        $result = [];
        foreach ($all as $item) {
            if ($onlyOne) {
                $value = $item[$firstKey];
            } else {
                $value = [];
                foreach ($columns as $column) {
                    $value[$column] = $item[$column];
                }
            }

            $result[$item[$key]] = $value;
        }

        return $result;
    }

    /**
     * Find by Primary key
     *
     * @param  mixed $id
     * @return array
     */
    public function find($id)
    {
        return $this->findOne([$this->key => $id]);
    }

    /**
     * Find one in table
     *
     * @param  array|null $filter
     * @param  array|null $options
     * @return array
     */
    public function findOne(array $filter = null, array $options = null)
    {
        $options = (array) $options;
        $options += [
            'limit'=>1,
        ];

        $result = $this->findAll($filter, $options);

        return $result?$result[0]:[];
    }

    /**
     * Find all in table
     *
     * @param  array|null $filter
     * @param  array|null $options
     * @return array<array>
     */
    public function findAll(array $filter = null, array $options = null)
    {
        $filter = (array) $filter;
        $options = (array) $options;
        $options += [
            'select'=>'*',
            'group'=>null,
            'order'=>null,
            'limit'=>null,
            'offset'=>null,
        ];

        $this->db
            ->select($options['select'])
            ->from($this->table);

        if ($filter) {
            $this->db->where($filter);
        }

        if ($options['group']) {
            $this->db->group_by($options['group']);
        }

        if ($options['order']) {
            $this->db->order_by($options['order']);
        }

        if (!is_null($options['limit'])) {
            $this->db->limit($options['limit'], $options['offset']);
        }

        $result = $this->db->get()->result_array();

        return $result;
    }

    /**
     * Paginate table
     *
     * @param  array|null $filter
     * @param  array|null $options
     * @return array
     */
    public function paginate(array $filter = null, array $options = null)
    {
        $filter = (array) $filter;
        $page = $this->input->get('page', 1);
            $page = $page > 0 ? $page : 1;
        $limit = $this->config->item('app_perpage');
        $offset = ($page - 1) * $limit;
        $startNumber = $offset;

        $this->db
            ->select('COUNT(*) AS total')
            ->from($this->table);
        if ($filter) {
            $this->db->where($filter);
        }
        $countResult = $this->db
            ->get()
            ->row();
        $count = $countResult?$countResult->total:0;

        $totalPage = ceil($count / $limit);

        $result = [
            'totalRecord'=>$count,
            'currentPage'=>$page,
            'maxPages'=>$totalPage,
            'firstNumber'=>$startNumber,
            'recordCount'=>0,
            'items'=>[],
        ];

        if ($count) {
            $result['items'] = $this->findAll($filter, $options);
            $result['recordCount'] = count($result['items']);
        }

        return $result;
    }

    /**
     * Save data
     *
     * @param  array      $data
     * @param  array|null $filter pass filter for updating data
     * @return bool
     */
    public function save(array $data, array $filter = null)
    {
        $filter = (array) $filter;

        if ($filter) {
            return $this->db->update($this->table, $data, $filter);
        } else {
            return $this->db->insert($this->table, $data);
        }
    }

    /**
     * Delete record
     *
     * @param  array|null $filter
     * @return mixed
     */
    public function delete(array $filter = null)
    {
        $filter = (array) $filter;

        return $this->db->delete($this->table, $filter);
    }

    /**
     * Generate serial number
     *
     * @param  string     $field
     * @param  string     $format
     * @param  array|null $filter
     * @return string
     */
    public function serialNumber($field, $format, array $filter = null)
    {
        $record = $this->findOne($filter, [
            'order'=>"$field DESC"
        ]);
        $latestSerial = $record?$record[$field]:null;

        $last = 0;
        $boundPattern = '/\{([a-z0-9\- _\.]+)\}/i';
        if ($latestSerial) {
            $pattern = preg_replace_callback($boundPattern, function($match) {
                return is_numeric($match[1])?
                    '(?<serial>'.str_replace('9', '[0-9]', $match[1]).')':
                    '(?<date>.{'.strlen(date($match[1])).'})';
            }, $format);
            if (preg_match('/^'.$pattern.'$/i', $latestSerial, $match)) {
                $last = $match['serial']*1;
            }
        }

        $serialNumber = preg_replace_callback($boundPattern, function($match) use ($last) {
            return is_numeric($match[1])?
                str_pad($last+1, strlen($match[1]), '0', STR_PAD_LEFT):
                date($match[1]);
        }, $format);

        return $serialNumber;
    }
}
