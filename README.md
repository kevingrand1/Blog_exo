# Pour lancer le projet :

```
composer install
```
```
npm install
```
```
npm run build
```

## | Base de données | (**MySQL**)


```
php bin/console doctrine:database:create
```
```
php bin/console make:migration
```
```
php bin/console doctrine:migration:migrate
```
## | Charger les fixtures (dummy datas) |
**avec faker et le fixtures bundle de symfony**

```
php bin/console doctrine:fixtures:load
```

## | Pour se connecter au site :
_email_: admin@admin.fr <br>
_mdp_ : Admin1234 <br>
_(Pour les autres users, mot de passe : 'Admin1234')_
