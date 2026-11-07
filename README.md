## プロジェクト名
- 「COACHTECH模擬案件　勤怠管理アプリ」

## 概要
- COACHTECHの模擬案件で作成した成果物
- 一般ユーザーが利用する勤怠管理アプリ
- 一般ユーザーは会員登録をした後、出勤・退勤・休憩時間の打刻、勤怠情報の確認・修正申請を行える
- 管理者はログイン後にスタッフ一覧や勤怠情報の確認・修正、修正申請の承認を行う

## ER図
![ER図](./images/er-diagram.png)

## 環境構築手順
- このプロジェクトをローカル環境で動かすための手順

### 前提条件
- DockerおよびDocker Desktopがインストールされていること

### 手順
- Bash機能を使おうとして2時間格闘しましたができませんでした。　地の文のまま見てください。
- 1.リポジトリをクローンする
- git clone <>
- cd <>

- 2.環境変数ファイルを作成する
- cp .env.example .env

- 3.composerパッケージをインストールする
- docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install

- 4.Sailを起動し、アプリケーションキーの生成とマイグレーションを行う
- ./vendor/bin/sail up -d
- ./vendor/bin/sail artisan key:generate
- ./vendor/bin/sail migrate

- 5.依存パッケージのインストールと起動
- ./vendor/bin/sail npm install
- ./vendor/bin/sail npm run dev

- 6.アプリケーションの起動
- npm run dev

- 7.動作確認
ブラウザで`http://localhost`にアクセスし、画面が表示されることを確認

## 使用技術
- Laravel 10
- MySQL 8.0
- Nginx
- Docker

## APIエンドポイント一覧
- 

## 開発環境URL
- http://localhost

## 作成者
- 渡辺瑞穂