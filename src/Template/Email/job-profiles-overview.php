<html>
    <body>
        <h1 style="color: #004590;">Job-Profile Übersicht für <?php echo $this->date ?></h1>

        <table rules="all" style="width:900px; border: 1px solid #004590;" cellpadding="10" cellspacing="0">
            <tr style="background: #004590;">
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Anrede</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Vorname</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Nachname</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">E-Mail</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Telefonnummer</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Straße + HausNr.</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Postleitzahl</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Stadt</td>
                <td style="font-weight:700; text-align:center; color: #fff; border: 1px solid #004590;">Aktion</td>
            </tr>

            <?php foreach ($this->items as $item) : ?>
                <tr style="background: #fff;">
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->salutation ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->firstname ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->lastname ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->email ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->phone ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->address ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->zip ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590;"><?php echo $item->city ?></td>
                    <td style="font-weight:normal; color: #004590; border: 1px solid #004590; text-align:center;">
                        <?php if ($item->created == $item->updated) : ?>
                            <span style="color: green;">Erstellt</span>
                        <?php else : ?>
                            <span style="color: red">Bearbeitet</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </body>
</html>