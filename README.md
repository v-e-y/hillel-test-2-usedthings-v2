## Download project
```
CMD: git clone git clone https://github.com/v-e-y/hillel-test-usedthings.git .
```

## Turn on/run and prepare project
```
- rename '.env.example' file to '.env'

CMD: docker-compose up -d --build
CMD: docker container exec -it hillel_test_2_usedsings_php /bin/bash
CMD: composer update
CMD: php artisan key:generate
CMD: php artisan migrate:fresh --seed
```

## To look the result
- open browser and new tab
```
http://localhost:7777/
```

## Run tests
```
CMD: docker-compose up -d
CMD: docker container exec -it hillel_test_2_usedsings_php /bin/bash
CMD: php artisan migrate:fresh --seed
CMD: php artisan test --testsuite=Feature
```


## Turn of/stop project
```
CMD: docker-compose down
```
