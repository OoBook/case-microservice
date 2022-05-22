

## Adım 1: Genel Uygulama Oluşumu
1) PHP Laravel ile Hello Enrich web sitesi oluşturulması.
    <!-- a) /ana-sayfa linkine girildiğinde ekranda “Hello Enrich MainPage” yazısının
    gösterilmesi beklenmektedir.
    b) /hata linkine girildiğinde “Sistemde bir hata oluştu” yazısının gözükmesi
    beklenmektedir. -->
2) Siteye veritabanı bağlanması
    a) Herhangi bir SQL ya da NoSQL veritabanı kullanılması ve erişimin sağlanması
    b) Test veritabanı adı: hello-enrich
    c) Test tablosu adı: users
    d) Test verisi: name, email (zorunlu alan)
3) Users microservice
    a) /users ve /users/{userid} ilgili linklerinden REST standartlarına uygun apiler ile
    users tablosuna CRUD işlemleri yapılmalıdır.

## Adım 2: Veri Yapıları ve Modelleme
1) Users ile 1-n bağlantıya sahip adres tablosu eklenmelidir.
    a) Adres tablosu city ve address alanlarından oluşur.
    b) Bir user silindiğinde ona ait adresler de silinmelidir.
    c) /users ile tüm userlar listelenirken adresleri gelmemeli ancak userid ile tek user
    çekildiğinde adres bilgileri de gelmelidir.
    <!-- d) City değişkeni sadece İSTANBUL, ANKARA, İZMİR şehirlerini içerebilmelidir. -->
    
2) User tablosuna “normalized_name” alanı eklenmesi
    <!-- a) Users tablosuna yeni bir “normalized_name” alanı eklenmeli. -->
    <!-- b) Bu alana doğrudan insert atılamamalıdır. -->
    <!-- c) Herhangi bir user oluşturulur ya da güncellenirken user’ın “name” alanı, tamamen
    lowercase, özel karakter içermeyen, sadece ingilizce harfler ve kelimeler arası
    tek boşluk içeren hale getirilerek otomatik olarak bu alana yazılmalı ve
    kaydedilmelidir. -->

Adım 3: Genişletilmiş Servis Yapısı
1) /users endpointine arama ve sıralama eklenmesi
    a) “Name” değişkeni ile girilen ad normalize edilerek (Adım 2 - Madde 2-c) aranır.
    Arama ilgili alanın herhangi bir yerinde yapılabilmeli, tam uyum, baştan ya da
    sondan arama gibi kısıt konulmalıdır. Ör: “ah” aratıldığında kayıtlarda varsa
    Ahmet, Sahar, Emrah kayıtları gelebilir.
    b) “City” değişkeni girilen şehre tam uyumla arama yapmalı ve bu şehirdeki userları
    listelemelidir.
    c) Userlar adlarına ya da şehirlerine göre azalan ya da artan şekilde
    sıralanabilmelidir.