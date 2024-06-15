<?php
namespace App\Utils;

class TableFetcher
{
    public function __construct()
    {
        $this->ModelClass = null;
        $this->FILTERS = [];
        $this->SORTING = [];
        $this->default_options = [
            "page_size" => 2,
            "page" => 1,
            "searchable_field" => "id",
            "search" => "",
            "sorting" => "desc",
        ];

        $this->postConstruct();

    }

    protected function postConstruct()
    {

    }


    public function get($extra_options)
    {
        $opts = $this->mergeOptionsWithDefaults($extra_options);
        $PROPS = [
            "PAGE_SIZE" => $opts['page_size'],
            "PAGE" => $opts['page'],
            "FILTER" => $this->FILTERS[$opts['searchable_field']]($opts['search']),
            "SORT" => $this->SORTING[$opts['searchable_field']]($opts['sorting']),
        ];

        $rows = $this->ModelClass::where(...$PROPS['FILTER'])
            ->offset(($PROPS['PAGE'] - 1) * $PROPS['PAGE_SIZE'])
            ->orderBy(...$PROPS['SORT'])
            ->take($PROPS["PAGE_SIZE"])
            ->get();

        $all = $this->ModelClass::where(...$PROPS['FILTER'])->count();

        $total = $this->ModelClass::count();

        return [
            "rows" => [...$rows],
            "totalRows" => $total,
            "pagesCount" => ceil($all / $PROPS['PAGE_SIZE']),
        ];
    }

    protected function mergeOptionsWithDefaults($opts)
    {
        $def = [...$this->default_options];

        if (array_key_exists("page", $opts))
            $def['page'] = (int) $opts['page'];

        if (array_key_exists("pageSize", $opts))
            $def['page_size'] = (int) $opts['pageSize'];

        if (array_key_exists("searchableField", $opts))
            $def['searchable_field'] = $opts['searchableField'];

        if (array_key_exists("search", $opts))
            $def['search'] = $opts['search'];

        if (array_key_exists("sorting", $opts))
            $def['sorting'] = $opts['sorting'] == 'asc' ? 'asc' : 'desc';

        return $def;
    }
}
