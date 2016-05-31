# PHP Initializer

**Note: this is just a Spike / Prototype / Proof of Concept**

Quickstart to Symfony project creator. Click on the options you require.

 * Owner/Namespace (eg. eddiejaoude)
 * Project name (eg. php-initializer)
 * Framework (eg. Symfony)
 * Framework version (eg. 1.8)
 * Production dependencies (eg. JMS Serialiser)
 * Development dependencies (eg. Behat)

 Then download the zip archive of your project

![Screenshot](docs/images/homepage.png)

---

## Installation

1. Clone the project
2. Install dependencies `composer install`
3. Run server `php bin/console server:run`
4. Visit http://localhost:8000/

## Configuration

Packages production & development: `app/config/services.yml`...

Example

```yaml
parameters:
  packages:
      prod:
        - { "JMS Serializer Bundle": "jms/serializer-bundle" }
        - { "FOS User Bundle": "friendsofsymfony/user-bundle" }
        - { "FOS Rest Bundle": "friendsofsymfony/rest-bundle" }
      dev:
        - { "PHP Unit": "phpunit/phpunit" }
        - { "PHP Spec": "phpspec/phpspec" }
        - { "Behat": "behat/behat" }
```
