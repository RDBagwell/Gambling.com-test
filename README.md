# Gambling.com Group - Take Home Test

##Task
Write a program that will read the full list of affiliates from this txt file and output the name and IDs of matching affiliates within 100km, sorted by Affiliate ID (ascending).

You can use the first formula from this [Wikipedia article](https://en.wikipedia.org/wiki/Great-circle_distance) to calculate distance. Don't forget, you'll need to convert degrees to radians.

The GPS coordinates for our Dublin office are 53.3340285, -6.2535495.

## Installation
After downloading the files in the root directory run:  

```
composer install
```  
then  

```
npm install
```
## Run Dev environment 
After all the dependencies have been installed rename **.env.example** to **.env** the run  
```npm
npm run watch
```  
In the browser open [http://localhost:8000/](http://localhost:8000/)  
You wit then be prompted to generate an APP_KEY click the green **GENERATE APP KEY** button on the top right.

## Usage  
You can upload the **affiliates.txt** from the root of the repository.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
