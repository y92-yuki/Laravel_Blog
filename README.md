# ひと言掲示板  
掲示板です。投稿に画像を添付することができます。

![gif](https://user-images.githubusercontent.com/69518643/170853857-e4849812-6744-4534-a025-4a2719637f83.gif)

## URL  
https://y-portfolio.net  
※ゲストユーザーでお試しください

# 使用技術
- MAMP
    - PHP 7.4.21
    - MySQL 5.7.34
    - Apache
- Laravel 6.20.44
- OpenWeatherMap
- Amazon Lightsail

# ライブラリ
- laravel-soft-cascade
- Intervention Image
- Guzzle

# 機能一覧
- ユーザー登録、ログイン機能(laravel/ui)
- 投稿機能
    - 画像投稿(Intervention Image)
    - コメント、いいね機能(Fetch API)
- メール認証
    - メールアドレス、パスワード変更時にメール認証