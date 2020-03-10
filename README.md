# Challenge

## Requirements:
Create a CLI tool that will accept a url for a StadiumGoods product listing page (PLP) like,
https://www.stadiumgoods.com/adidas, and output a csv like:

"Product Name","Price"
"Air Jordan 1 Hi OG TS SP",$940.00
"Air Jordan 6",$255.00
"Air Jordan 1 Retro High OG",$325.00

The CSV file generated should be output to stdout

## Result:
I've changed csv file format: the "Currency" column added

## Installation:
This is the Magento platform module.
  1. Install Magento v.2.3.3 on your server: [Magento installation guide](https://devdocs.magento.com/guides/v2.3/install-gde/bk-install-guide.html)
  2. Deploy this module:
  ```
        composer config  repositories.Eermolaev_Challenge git git@github.com:eermolaev/Eermolaev_Challenge.git;
        composer require eermolaev/challenge;
  ```
  3. Install module:
  ```
    bin/magento setup:upgrade
    bin/magento setup:di:compile
    bin/magento setup:static-content:deploy
  ``` 

## How to use:
If you completed installation step correctly - new console command `./bin/magento  eermolaev_challenge:parse_url_to_csv` will be available in your Magento.
1. Open your Magento folder
2. Run the following command: `./bin/magento  eermolaev_challenge:parse_url_to_csv https://www.stadiumgoods.com/adidas`
