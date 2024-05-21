1) git clone https://github.com/maxlastik/lara-cities.git
2) composer install
3) copy .env.example .env
4) php artisan key:generate
5) touch database/database.sqlite
6) php artisan migrate
 ----
7) Open /load-cities to parse cities from API and fill DB. It will take some time.




API:
1) Add new city - 
   POST
   "api/cities"
   Request Body:
   {
       "name":"Серпухов"
   }
   
   Response:
   {
        "message":"Ok"
   }
   
3) Delete city - 
   DELETE
   "api/cities/{city}"
   
   Response:
   {
        "message":"Ok"
   }
