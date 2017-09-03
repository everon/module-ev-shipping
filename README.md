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


