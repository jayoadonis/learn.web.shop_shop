<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;

//REM: [TODO, PROPER_GENERIC]
class ParamPath extends ObjectI {

    /**
     * @var array<string,string> Data items where keys and values are strings.
     */
    private array $datas = [];

    /**
     * @var array<int, string> Valid parameter keys.
     */
    private array $validParamPathKeys;

    /**
     * Constructor.
     *
     * @param array<string,string> $datas Initial data.
     * @param array<int,string>   $validParamPathKeys  Allowed keys (defaults to ["id", "verb"]).
     */
    public function __construct(
        array $datas,
        array $validParamPathKeys = ["id", "verb"]
    ) { 
        $this->validParamPathKeys = $validParamPathKeys;
        $this->set($datas);
    }

    /**
     * Adds one or more valid parameter path keys.
     *
     * @param string|array<int,string> $paramPathKeys A single key or an array of keys.
     * @return bool True if at least one new key was added; false otherwise.
     */
    public function addValidParamPathKey(string|array $paramPathKeys): bool {
        $added = false;
        if (is_array($paramPathKeys)) {
            foreach ($paramPathKeys as $path) {
                if (!in_array($path, $this->validParamPathKeys, true)) {
                    $this->validParamPathKeys[] = $path;
                    $added = true;
                }
            }
        } else {
            if (!in_array($paramPathKeys, $this->validParamPathKeys, true)) {
                $this->validParamPathKeys[] = $paramPathKeys;
                $added = true;
            }
        }
        return $added;
    }

    /**
     * Inserts a key-value pair into the data array if the key is valid.
     *
     * @param string $key   The key to insert.
     * @param string $value The value associated with the key.
     * @return string|null Returns the key if insertion is successful, null otherwise.
     */
    public function insert(string $key, string $value): ?string {
        if (in_array($key, $this->validParamPathKeys, true)) {
            $this->datas[$key] = $value;
            return $key;
        }
        return null;
    }

    /**
     * Sets the data array if it contains at least one allowed key.
     *
     * @param array<string,string> $datas The data to set.
     * @return bool True if the data is valid and set; false otherwise.
     */
    public function set(array $datas): bool {
        //REM: Check if at least one key in $datas is allowed.
        $allowedKeys = array_intersect(array_keys($datas), $this->validParamPathKeys);
        if (empty($allowedKeys)) {
            return false;
        }
        $this->datas = $datas;
        return true;
    }

    /**
     * Retrieves the value for a given key.
     *
     * @param string $key The key whose value to retrieve.
     * @return string|null Returns the associated value or null if not found.
     */
    public function get(string $key): ?string {
        return $this->datas[$key] ?? null;
    }

    //REM: [TODO] .|. Deep clone it layer or other immutable optimzation...
    public function getData(): array {

        return $this->datas;
    }
}
