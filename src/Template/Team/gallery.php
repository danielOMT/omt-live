<section class="omt-row team-members-gallery-section">
    <div class="wrap team-members-gallery">
        <div class="team-gallery-items x-flex x-flex-wrap x-mt-16">
            <?php foreach ($this->rows as $row) : ?>
                <?php if ($row['inhaltstyp'][0]['acf_fc_layout'] === 'team_member') : ?>
                    <div class="team-gallery-item x-flex">
                        <button 
                            type="button" 
                            class="x-bg-transparent x-border-0 x-p-0"
                            onclick="scrollToTeamMember(<?php echo $row['inhaltstyp'][0]['default_image']['ID'] ?>)"
                        >
                            <img
                                src="<?php echo $row['inhaltstyp'][0]['default_image']['sizes']['285-285'] ?>"
                                alt="<?php echo $row['headline'] ?>"
                                title="<?php echo $row['headline'] ?>"
                                class="x-rounded"
                            >
                        </button>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</section>