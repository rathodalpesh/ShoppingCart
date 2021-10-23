<?php

namespace Database\Seeders;
use App\Models\ProductSubCategory;
use Illuminate\Database\Seeder;

class ProductSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websiteData = array();

        $website     = ProductSubCategory::select('id', 'sub_cat_name')->pluck('sub_cat_name', 'id')->toArray();
         
        if( !in_array('Samsung', $website) ) {
            $websiteData[] = [
                'cat_id'         => '1',
                'sub_cat_name'   => 'Samsung',
            ];
        }
        if( !in_array('Apple', $website) ) {
            $websiteData[] = [
                'cat_id'         => '1',
                'sub_cat_name'   => 'Apple',
            ];
        }
        if( !in_array('Maruti', $website) ) {
            $websiteData[] = [
                'cat_id'         => '2',
                'sub_cat_name'   => 'Maruti',
            ];
        }
        if( !in_array('Hyundai', $website) ) {
            $websiteData[] = [
                'cat_id'         => '2',
                'sub_cat_name'   => 'Hyundai',
            ];
        }
        if( !in_array('TATA', $website) ) {
            $websiteData[] = [
                'cat_id'         => '2',
                'sub_cat_name'   => 'TATA',
            ];
        }
        if( !in_array('LG', $website) ) {
            $websiteData[] = [
                'cat_id'         => '3',
                'sub_cat_name'   => 'LG',
            ];
        }
        if( !in_array('Onida', $website) ) {
            $websiteData[] = [
                'cat_id'         => '3',
                'sub_cat_name'   => 'Onida',
            ];
        }
        if( !in_array('Arvind', $website) ) {
            $websiteData[] = [
                'cat_id'         => '4',
                'sub_cat_name'   => 'Arvind',
            ];
        }
        if( !in_array('Arrow', $website) ) {
            $websiteData[] = [
                'cat_id'         => '4',
                'sub_cat_name'   => 'Arrow',
            ];
        }
        if( !in_array('Raymond', $website) ) {
            $websiteData[] = [
                'cat_id'         => '4',
                'sub_cat_name'   => 'Raymond',
            ];
        }
        return ProductSubCategory::insert($websiteData);
    }
}
