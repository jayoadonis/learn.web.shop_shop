<?php
declare(strict_types=1);

namespace learn\web\shop_shop\models\routes;

use learn\web\shop_shop\models\ObjectI;
use learn\web\shop_shop\models\Status;
use learn\web\shop_shop\utils\Option;

//REM: [TODO, PROPER_GENERIC]
class ParamPath extends ObjectI {

    /**
     * @var array<string,string> Data items where keys and values are strings.
     */
    private array $datas = [];

    /**
     * @var array<string> Valid parameter keys.
     */
    private array $validParamPathKeys;

    /**
     * Constructor.
     *
     * @param array<string,string> $datas Initial data.
     * @param array<string>   $validParamPathKeys  Allowed keys (defaults to ["id", "verb"]).
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
     * @param string|array<string> $paramPathKeys A single key or an array of keys.
     * @return bool True if at least one new key was added; false otherwise.
     */
    public function addValidParamPathKey(string|array $paramPathKeys): bool {
        $added = false;
        if (is_array($paramPathKeys)) {
            foreach ($paramPathKeys as $pathKey) {
                if (!in_array($pathKey, $this->validParamPathKeys, true)) {
                    $this->validParamPathKeys[] = $pathKey;
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
    //REM: [TODO] .|. Is early returning the best way here???
    public function set(array $datas): bool {

        /**
         * 
         * @var array<string> 
         */
        $requestedPathBlueprintKeys = array_keys($datas);

        //REM: filter the user/client requested path blueprint
        /**
         * 
         * @var array<string> 
         */
        $computedAllowedPathBlueprintKeys = array_intersect($requestedPathBlueprintKeys, $this->validParamPathKeys);

        //REM: If the requested client param path keys did not stricly had the desirable valid 
        //REM: param path keys do not add the said client param path keys.
        if ( count($computedAllowedPathBlueprintKeys) !== count($requestedPathBlueprintKeys)) {
            return false;
        }

        $this->datas = $datas;

        return true;
    }

    /**
     * Retrieves the value for a given key.
     * 
     * @param string $key The key whose value to retrieve.
     * @return Option<string>
     */
    public function get(string $key): mixed {

        $value = $this->datas[$key]?? null;

        return $value !== null 
            ? Option::some( $value ) 
            : Option::none();
    }

    //REM: [TODO] .|. Deep clone it layer or other immutable optimzation...
    public function getData(): array {

        return $this->datas;
    }

    //REM: [TODO] .|. Deep clone later....
    public function getValidParamPathKeys(): array {

        return $this->validParamPathKeys;
    }
}
