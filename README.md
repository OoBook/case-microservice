# Enrich microservices

## Başlarken

Microservice yapısını geliştirirken öncelikle Lumen framework ile geliştirmeye başlanmıştır, ancak isterlerin daha sonra netleşmesinden ötürü projenin lumen'e değil Laravel'e uygun olduğu görülmüştür. Bu yüzden projenin ortasında lumen'den laravel'e upgrade edilmiştir. Lumen projesi de silinmemiştir, root path'de user klasörü lumen main/ klasörü laravel projesi olarak durmaktadır. Örnek projenin nasıl başlandığı ve nasıl devam edildiğinin anlaşılması için incelenebilir.

Sistemin yapısı genel olarak main/ klasörünün içerisinden başlamaktadır. Buradaki laravel projesi docker üzerinde çalışacak şekilde konfigüre edilmiştir. Container listesi şu şekildedir
-   enrich (php-fpm)
-   nginx
-   main_db (mariadb)
-   library_db (mariadb)
-   phpmyadmin
-   mongo
-   mongo-webui

enrich php ortamı için geliştirilmiş bir container. DB yapısı 3'e bölünmüştür, 2 mysql host ve 1 mongodb host olarak 3 DB container'ı vardır. 1. mysql host ana yapıyı user ve roller'i taşımaktadır. 2. mysql host ise library bilgilerini taşımaktadır. 3. olarak mongodb container ise address bilgilerini içermektedir. Laravel içerisinde bununla ilgili
hybrid yapı kurulmuştur.

Ayrıca mysql ve mongo veritabanlarını incelemek için aşağıdaki portlarla tarayıcıdan bağlanabilirsiniz.
-   localhost:8080 (phpmyadmin)
    1. main_db

            -   host: main_db
            -   username: root
            -   password: root
    2. library_db

            -   host: main_db
            -   username: root
            -   password: root
-   localhost:3000 (mongodb) (connection kaydedin.)

            -   connection name: mongo
            -   port: 27017
            -   database name: mongo

### Note
3000, 80, 8080, portlarının boşta olduğundan emin olun. 80 portu boşta değilse, local'deki url 80 üzerinden çalışmayacaktır.
## Yapı

Proje user, address, library modüllerinden oluşmaktadır. Aşağıda end-pointler listelenmiştir.

-   /users
-   /users/{user}/addresses/{address}
-   /libraries

address modülü user içine nested olarak eklenmiştir. Library modülü User tarafından abone olacak şekilde tasarlanmıştır. User list tablosundan address eklenecek ve library'e kayıt yapacak şekilde tasarlanmıştır. Library modülünün veritabanı ayrı bir container host'da tutulmaktadır.

/login sayfasından aşağıdaki credentials ile giriş yapabilirsiniz.
ADMIN ROLE
    
    -   admin@gmail.com
    -   111111

USER ROLE

    -   test@gmail.com
    -   111111

/register sayfasından kayıt yapabilirsiniz, default olarak role USER olacaktır.

## Docker Run

Docker projesinin konfigürasyonları, docker-compose.yml içerisinde yapılmıştır. Öncelikle container'ları oluşturmak için aşağıdaki komutları takip ediyoruz.

```bat
    cd main
    docker-compose up -d
```

Container'ları ayağa kaldırdıktan sonra aşağıdaki komutla enrich container'ına girdikten sonra sıralı olarak komutları çalıştırın.

```bat
    docker-compose exec enrich bash
```

```bat
    composer install --ignore-platform-reqs
    cp .env.example .env
    php artisan key:generate
    php artisan migrate -seed
```

## Unit Testing

Bütün işlemler tamamlandıktan sonra, test işlemleri için yine enrich container'ı içinden şu komutu çalıştırıp test sonuçlarını gözlemleyin.

```bat
    php artisan test
```
