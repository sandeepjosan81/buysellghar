<?php


namespace InnoShop\Panel\Components\Forms;

use Illuminate\View\Component;

class AutocompleteList extends Component
{
    public string $name;

    public string $title;

    public array $value;

    public string $api;

    public bool $required;

    public string $placeholder;

    public array $selectedItems;

    /**
     * Create a new component instance.
     * Supports passing complete data of selected items to avoid additional API calls
     */
    public function __construct(string $name, array $value, string $api, array $selectedItems = [], string $placeholder = 'Please search', bool $required = false, string $title = 'Search Results')
    {
        $this->name          = $name;
        $this->value         = $value;
        $this->title         = $title;
        $this->api           = $api;
        $this->selectedItems = $selectedItems;
        $this->placeholder   = $placeholder;
        $this->required      = $required;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        $data['id'] = str_replace(['[', ']'], '', $this->name);

        return view('panel::components.form.autocomplete-list', $data);
    }
}
