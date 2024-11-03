<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($userInfo['username']); ?> - Profile</title>
</head>
<body>

<div class="container">
    <!-- Perfil del usuario -->
    <div class="profile-header">
        <h1><?php echo htmlspecialchars($userInfo['username']); ?></h1>
        <p><?php echo htmlspecialchars($userInfo['bio']); ?></p>
    </div>

    <div class="profile-stats d-flex justify-content-around">
        <div>
            <h5>Seguidores</h5>
            <p><?php echo $followersCount; ?></p>
        </div>
        <div>
            <h5>Seguidos</h5>
            <p><?php echo $followingCount; ?></p>
        </div>
    </div>

    <!-- Lista de tweets del usuario -->
    <div class="user-tweets">
        <h3>Tweets</h3>
        <?php if (!empty($tweets)): ?>
            <?php foreach ($tweets as $tweet): ?>
                <div class="tweet-card">
                    <div class="tweet-content">
                        <p><?php echo htmlspecialchars($tweet['text']); ?></p>
                        <small class="text-muted"><?php echo htmlspecialchars($tweet['createDate']); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                No tweets to show.
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>