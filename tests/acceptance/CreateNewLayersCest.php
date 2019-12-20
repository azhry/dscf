<?php 
// vendor/bin/codecept run acceptance CreateNewLayersCest --steps
require 'vendor/autoload.php';

class CreateNewLayersCest
{
	private $faker;

    public function _before(AcceptanceTester $I)
    {
    	$this->faker = Faker\Factory::create();
    }

    public function CreateNewLayerFormTest(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/main/create_layers');
        $I->see('Create New Layer Form');

        $I->fillField('name', $this->faker->catchPhrase);
        $I->fillField('description', $this->faker->realText);

        $geotype = ['Polyline', 'Line', 'Markers', 'Shield', 'Line Pattern', 'Polygon Pattern', 'Raster', 'Point', 'Text', 'Building'];
        $I->selectOption('geotype', $geotype[$this->faker->numberBetween(0, count($geotype) - 1)]);
        
        $I->fillField('icon', realpath(__DIR__ . '/../_data/icons/icons8-marker-100.png'));
        $I->fillField('shapefile', realpath(__DIR__ . '/../_data/icons/icons8-marker-100.png'));

        $I->click('Submit');

    	$I->makeScreenshot();
    	$I->see('New layer added');
    }
}
