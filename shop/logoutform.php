<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログアウトフォーム｜ショッピングサイト</title>
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    
    <?php
        session_cache_limiter('none');
        session_start();
        require 'defo.php';
    ?>

<!-- ログアウト確認 -->
 <main>
      <?php if (isset($_SESSION['login'])): ?> 
         <div class="login-message"> 
               <p><?= htmlspecialchars($_SESSION['login']['name']) ?> 様、ログアウトしますか？</p>
               
          <div style="display:flex; justify-content:center; gap:10px; margin-top:10px;"> 
              <form action="logout.php" method="POST"> 
                  <input type="submit" value="はい" 
                      style="padding:10px 20px; background-color:#3498db; color:white; border:none; border-radius:5px;"> 
              </form> 
              
              <button onclick="history.back()" 
                  style="padding:10px 20px; background-color:#ccc; border:none; border-radius:5px;"> 
                  戻る 
              </button> 
          </div> 
         </div>
     
       <?php else: ?>
            <div class="login-message"> 
                <p>ログインしていません。</p> 
                <a href="loginform.php" style="display:inline-block; margin-top:10px; padding:10px 20px; background-color:#5dade2; color:white; border-radius:5px; text-decoration:none;"> 
                    ログイン画面へ 
                </a> 
            </div> 
        <?php endif; ?>
 </main>
    
    <footer class="site-footer">
        <p>&copy; 2025 ショッピングサイト | お問い合わせ | 利用規約 | プライバシー</p>
    </footer>

</body>
</html>
