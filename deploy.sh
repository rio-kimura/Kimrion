#!/bin/bash
set -e

echo "🚀 デプロイ(更新)を開始します..."

# 1. メンテナンスモード ON
php artisan down || true

# 2. ソースコード更新
echo "📥 Git Pull..."
git pull origin main

# 3. 依存関係の更新
echo "📦 Composer Install..."
composer install --optimize-autoloader --no-dev

# 4. フロントエンドビルド (必要な場合)
echo "🎨 NPM Build..."
npm install
npm run build

# 5. データベース更新
echo "🗄️ DB Migration..."
php artisan migrate --force

# 6. キャッシュクリア
echo "🧹 Cache Clear..."
php artisan optimize:clear
php artisan view:clear
php artisan config:clear

# 7. 権限の修正 (念のため)
# ※ ユーザー名は環境に合わせて 'rio' などに変更してください
sudo chown -R rio:nginx storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 8. メンテナンスモード OFF
php artisan up

echo "✅ 更新が完了しました！"
