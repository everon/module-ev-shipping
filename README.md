[![Codacy Badge](https://api.codacy.com/project/badge/Grade/05fcaa78376d4f43af31084a087fe467)](https://www.codacy.com/app/everon/module-ev-shipping?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=everon/module-ev-shipping&amp;utm_campaign=Badge_Grade)


Magento 2 - EV Shipping (JSON Shipping Rates)
======================================

This module is designed with both developers and clients in mind.

Loosely based on Matrix Rates, the module allows for easy extension of the available shipping rules, it also does away
with the tedious editing of a CSV file and replaces it with a more logical JSON format which can also be extended.

All rates are passed through a series of filters which return a boolean value to determine if they are available,
once all filters are run, the remaining rates are those that are available for the customer.

More rates can be easily added, at the moment this means editing the module directly but a way to add rates from other
modules (i.e. client specific rates) will be available in the future.

The module is functionally complete and care has been taken to ensure this is tested well, as the module does not use
a database connection (only flat files for you git users) the tests are very quick to run.

I have tried to adhere to the Magento 2 marketplace standards as much as possible although there are places where I have
had to break from this (the standards checker does not recognize factories or immuatable objects among other things).

Ideas for future features/filters/improvements are welcome (create a ticket).

## Filters
There are a number of predefined filters available

* Postcode (UK)
* Country code (GB, FR, etc)
* Cart Item Count (range, minimum, maximum)
* Cart Weight (range, minimum maximum)
* Website ID

All filters can be wild carded (bypass) in their entirety for individual rules by removing their entries from the shipping config file.
The bare minimum attributes required at the ID, Name, Price and Sort (sort isn't actively used yet in filtering).

### Postcode
The postcode filter works with both exact and partial matches, for example:
* BD - Would match postcodes that start with BD (Bradford)
* BD17 - Match postcodes that are part of BD17 (Shipley)
* BD17 7DB - Match postcodes to a full postcode for our a most specific area

The postcode filter can accept zero or many postcodes.

JSON
```json
{
    "rates": [
        {
            "id": 20,
            "name": "Postcode Test",
            "postcodes": [
                "LS", "BD17 7DB"
            ],
            "price": "3.50"
        }
    ]
}
```

### Cart Item Count and Total Weight (Ranged Filters)
The item count and weight total work on a ranged filter which uses identical syntax.
Like other filters, this can be omitted from the config completely.

Ranged filters are allowed to have either:
* No filter (removed from schema)
* Minimum only (`from` attribute is set)
* Maximum only (`to` attribute is set)
* Range (Both `from` and `to` are set)

This means that the filter works differently depending on the number of parameters set against it.

JSON
```json
{
    "rates": [
        {
            "id": 20,
            "name": "Ranged Test",
            "weight": {
                "to": 10
            },
            "cart_price": {
                "from": 10
            },
            "price": "3.50"
        }
    ]
}
```



