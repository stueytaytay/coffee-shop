# General Notes

Moved from Laravel Mix to Vite for more efficient development. Also updated Tailwind, Tailwind Forms and Autoprefixer, along with required config changes.

Updates phpunit.xml due to deprecated schema

I opted to use Livewire for ease of implementation, front end reactivity and validation

Added a confirmation message if the user tries to leave a settings (Coffee Types or Shipping Partners) page after making changes and not saving

Added a basic "Load More" pagination

- Sales

New sales and previous sales are segmented into different Livewire components and blade templates

Calculations are done on keyup and recording the sale is done without refreshing the page

I have added a delete button for soft deletes of sales

Created a seeder class to add sales to the DB


- Coffee types

Added a new route, view, model and component to manage coffeee types

Validation ensures there are no duplicate coffee names

Again with a soft delete button, with confirmation

If a CoffeType does get trashed, it will still be shown in the previous sales, and will be a light grey to show this

Created a seeder class to add coffee types to the DB - this is called before the CoffeeSalesTableSeeder so the sales has a CoffeeType associated with it

Also a factory class so the tests can run


- Shipping partners

I used the already existing route and view, then created a Livewire component, migration and seeder, then also set the CoffeeType relationship in the models

Added validation to ensure a shipping partner is selected on the coffee type

Added a column to previous sales showing the shipping information

Amended the tests to account for the new ShippingPartner


Additional features I would implement in the future:

- OrderBy sales columns, sales search, filtering and better pagination - Livewire Tables (https://github.com/rappasoft/laravel-livewire-tables) would be ideal for this
- Ability to edit sales
- Improve UI & mobile responsive
- Currency selection - with default and custom selection
- Invoice creation
- Ability to export sales
- Custom order references
- User management
- Reporting