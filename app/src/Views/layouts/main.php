<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle ?? Yii::app()->name); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        header { background: #2c3e50; color: white; padding: 15px 0; }
        header nav { display: flex; justify-content: space-between; align-items: center; }
        header nav a { color: white; text-decoration: none; margin-left: 20px; }
        header nav a:hover { text-decoration: underline; }
        .logo { font-size: 1.5em; font-weight: bold; }
        main { padding: 30px 0; min-height: calc(100vh - 150px); }
        .flash { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .flash.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .flash.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn { display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 4px; cursor: pointer; border: none; font-size: 14px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn:hover { opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .error { color: #e74c3c; font-size: 12px; margin-top: 5px; }
        .errorSummary { background: #f8d7da; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        footer { background: #f8f9fa; padding: 20px 0; text-align: center; color: #666; }
        h1 { margin-bottom: 20px; }
        .actions { margin-bottom: 20px; }
        .book-cover { max-width: 200px; max-height: 300px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo"><?php echo CHtml::link(Yii::app()->name, ['/']); ?></div>
                <div>
                    <?php echo CHtml::link('Книги', ['book/index']); ?>
                    <?php echo CHtml::link('Авторы', ['author/index']); ?>
                    <?php echo CHtml::link('ТОП-10', ['report/index']); ?>
                    <?php if (Yii::app()->user->isGuest): ?>
                        <?php echo CHtml::link('Войти', ['auth/login']); ?>
                        <?php echo CHtml::link('Регистрация', ['auth/register']); ?>
                    <?php else: ?>
                        <span>Привет, <?php echo CHtml::encode(Yii::app()->user->name); ?>!</span>
                        <?php echo CHtml::link('Выйти', ['auth/logout']); ?>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <?php foreach (['success', 'error'] as $type): ?>
                <?php if (Yii::app()->user->hasFlash($type)): ?>
                    <div class="flash <?php echo $type; ?>">
                        <?php echo Yii::app()->user->getFlash($type); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php echo $content; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            &copy; <?php echo date('Y'); ?> Каталог книг
        </div>
    </footer>
</body>
</html>
