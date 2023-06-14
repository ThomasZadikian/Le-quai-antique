<?php

namespace App\Repository;

class Tools
{
    public array $allergens = [];

    public function sortAllergens($menu): array
    {

        foreach ($menu as $id => $value) {
            $allergenList = explode(',', $menu['entree_allergen']);
            $allergenList = array_map('trim', $allergenList);
            $this->allergens = array_merge($this->allergens, $allergenList);

            $allergenList = explode(',', $menu['plat_allergen']);
            $allergenList = array_map('trim', $allergenList);
            $this->allergens = array_merge($this->allergens, $allergenList);

            $allergenList = explode(',', $menu['dessert_allergen']);
            $allergenList = array_map('trim', $allergenList);
            $this->allergens = array_merge($this->allergens, $allergenList);
        }
        $this->allergens = array_unique($this->allergens);
        sort($this->allergens);
        return $this->allergens;
    }
}
