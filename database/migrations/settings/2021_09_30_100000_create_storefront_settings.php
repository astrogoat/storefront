<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateStorefrontSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('storefront.enabled', false);
         $this->migrator->add('storefront.currency', '');
        // $this->migrator->addEncrypted('storefront.access_token', '');
    }

    public function down()
    {
        $this->migrator->delete('storefront.enabled');
        $this->migrator->delete('storefront.currency');
        // $this->migrator->delete('storefront.url');
        // $this->migrator->delete('storefront.access_token');
    }
}
