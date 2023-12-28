<?php
  $pdo = new PDO("sqlite:chinook.db");
  $sql = 'SELECT * FROM playlists ORDER BY Name';
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $playlists = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Playlists</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Playlists</h1>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($playlists as $playlist) : ?>
          <tr>
            <td>
              <?php echo $playlist->Name ?>
            </td>
            <td>
              <a href="playlist.php?id=<?php echo $playlist->PlaylistId ?>">
                View
              </a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</body>
</html>