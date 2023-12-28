<?php
  if (!isset($_GET['id'])) {
    header('Location: playlists.php');
    exit;
  }

  $pdo = new PDO("sqlite:chinook.db");
  $sql = 'SELECT * FROM playlists WHERE PlaylistId = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id']);
  $statement->execute();
  $playlist = $statement->fetch(PDO::FETCH_OBJ);

  $sql = '
    SELECT 
      tracks.Name AS trackName,
      tracks.UnitPrice AS price,
      albums.Title AS albumTitle,
      artists.Name AS artistName,
      genres.Name AS genreName
    FROM playlist_track
    INNER JOIN tracks
    ON playlist_track.TrackId = tracks.TrackId
    INNER JOIN albums
    ON tracks.AlbumId = albums.AlbumId
    INNER JOIN artists
    ON albums.ArtistId = artists.ArtistId
    INNER JOIN genres
    ON genres.GenreId = tracks.GenreId
    WHERE playlist_track.PlaylistId = :id
    ORDER BY trackName
  ';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id']);
  $statement->execute();
  $tracks = $statement->fetchAll(PDO::FETCH_OBJ);
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
    <h1>
      <?php echo $playlist->Name ?>
    </h1>

    <?php if (count($tracks) === 0) : ?>
      <p>No tracks found for the <?php echo $playlist->Name ?> playlist.</p>
    <?php else : ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Track</th>
            <th>Album</th>
            <th>Artist</th>
            <th>Genre</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($tracks as $track) : ?>
            <tr>
              <td>
                <?php echo $track->trackName ?>
              </td>
              <td>
                <?php echo $track->albumTitle ?>
              </td>
              <td>
                <?php echo $track->artistName ?>
              </td>
              <td>
                <?php echo $track->genreName ?>
              </td>
              <td>
                $<?php echo $track->price ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php endif ?>
  </div>
</body>
</html>