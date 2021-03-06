<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InstallLavender extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// only run this seed if store doesn't exist
		if(!$this->container->store->exists){

			// create default store
			$store = entity('store')->create([
				'default' => true,
			]);

			// set the current store scope
			$this->container->store->setStore($store);

			// create default theme
			$theme = entity('theme')->create([
				'code'  => 'default',
				'name'  => 'Default Theme',
			]);

			// create root category
			$category = entity('category')->create([
				'name' => 'Root Category',
			]);

			// update store
			$store->update([
				'theme'         => $theme,
				'root_category' => $category,
			]);

            $this->command->info("Lavender has successfully installed!");

		}
	}

}
