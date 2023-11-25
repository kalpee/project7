# project7

# Usage

環境構築

```bash
プロジェクトをクローン
git clone https://github.com/kalpee/project7.git

プロジェクトディレクトリに移動
cd project7

composerインストール
composer install

.envファイル作成
cp .env.example .env

Dockerビルド
docker-compose build

必要ライブラリインストール
docker-compose run app npm install vue@next -D
docker-compose run app npm install vue-loader@next -D
docker-compose run app npm install @vue/compiler-sfc -D
docker-compose run app npm install @types/webpack-env typescript ts-loader -D

コンテナ起動
docker-compose up -d

npm起動
docker-compose run app npm run dev

laravelのキー作成
php artisan key:generate

appコンテナに入ってマイグレーション
docker exec -it project7_app_1 php artisan migrate

dbコンテナに入る
mysql -h 127.0.0.1 -P 33306 -u root -p

使用するDB選択
use project7_db_1

テーブル一覧
SHOW TABLES;

マイグレーションしたテーブルがあればOK
```

# Note

注意点などがあれば書く
