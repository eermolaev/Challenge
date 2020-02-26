# Challenge

## Requirements:
Create a CLI tool that will accept a url for a StadiumGoods product listing page (PLP) like,
https://www.stadiumgoods.com/adidas, and output a csv like:

"Product Name","Price"
"Air Jordan 1 Hi OG TS SP",$940.00
"Air Jordan 6",$255.00
"Air Jordan 1 Retro High OG",$325.00

The CSV file generated should be output to stdout

`curl -s https://www.stadiumgoods.com/adidas |  tr  "\n" " "|grep -o '<div [^>]*product-name[^>]*.*?<span class="price">[^>]*</span>'`