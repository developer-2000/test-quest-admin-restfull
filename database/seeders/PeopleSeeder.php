<?php
namespace Database\Seeders;

use App\Models\Company;
use App\Models\People;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;

class PeopleSeeder extends Seeder {

    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     * @return void
     */
    public function run() {
        $companies = (new Company())->get();
        $arr = [];

        foreach ($companies as $key => $company){
            $arr[] = [
                'company_id'=>$company->id,
                'name'=>$this->faker->text(15),
            ];
        }
        People::insert($arr);
    }
























}
