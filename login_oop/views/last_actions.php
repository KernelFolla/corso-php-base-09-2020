<?php
/**
 * @var $results
 */
?>
<table border="1">
    <tr>
        <th>id</th>
        <th>username</th>
        <th>action</th>
        <th>created at</th>
    </tr>
    <?php foreach ($results as $row) { ?>
        <?php $createdAt = new DateTime($row->created_at); ?>
        <tr>
            <td><?php echo $row->id ?></td>
            <td><?php echo $row->username ?></td>
            <td><?php echo $row->action ?></td>
            <td><?php echo $createdAt->format('d/m/Y H:i:s') ?></td>
            <td><a href="?delete_log=<?php echo $row->id ?>">Cancella</a></td>
        </tr>
    <?php } ?>
</table>
