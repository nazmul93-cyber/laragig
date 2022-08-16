<?php

namespace app\Models;

class Listing {
    public static function all() {
        return [
            [
                'id' => '1',
                'title' => 'listing one',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Convallis posuere morbi leo urna molestie. Senectus et netus et malesuada fames ac. Ullamcorper morbi tincidunt ornare massa eget egestas purus'
            ],
            [
                'id' => '2',
                'title' => 'listing two',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Convallis posuere morbi leo urna molestie. Senectus et netus et malesuada fames ac. Ullamcorper morbi tincidunt ornare massa eget egestas purus'
            ]
        ];
    }

    public static function find($id) {
        $listings = self::all();
        
        foreach($listings as $listing) {
            if ($listing['id'] == $id) {
                    return $listing; 
            } 
        }

    }
}