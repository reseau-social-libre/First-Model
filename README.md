# RSL (https://rsllibre.com)

> RSL is a non censured social network open source project under GPLv3 licence.
> 
> Everyone can participate to:
> 1. Modify it.
> 2. Improve it.
> 3. Bring his ideas.

## Goal of this project.

> This project is open source and is not affiliated over any organization or country.
>
> RSL aims to provide a free space where members can express themselves and share freely without censorship (Pornography, pedophilia and incitement to hate are prohibited).

## Infos resources.
1. Facebook page: [https://www.facebook.com/Resauxsociallibre](https://www.facebook.com/Resauxsociallibre)
2. Discord: [https://discord.gg/jyqvmER](https://discord.gg/jyqvmER ) 

## How to install
> RSL is a project based on the Symfony4 PHP Framework.

1. Clone the projet from github repository.
    > HTTPS:  ``> git clone https://github.com/reseau-social-libre/First-Model.git``
    >
    > SSL: ``> git clone https://github.com/reseau-social-libre/First-Model.git``

2. Install vendor.
    > ``> cd First-Model/symfony``
    > ``> composer install``
    
3. Install database.
    1. Copy .env to a new file named .env.local
    2. Update this line with your MySql server credentials:
        ``DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name``
    3. ``> php bin/console doctrine:database:create``
    4. ``> php bin/console doctrine:migration:migrate``
    5. ``> php bin/console doctrine:fixture:load``
    
4. Install all assets
    1. Run ``> yarn install``
    2. Then run ``> yarn encore dev``

