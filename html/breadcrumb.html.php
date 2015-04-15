<?php if (isset($breadcrumb) and !empty($breadcrumb)) { ?>
    <div class="breadCrumbHolder module">
        <div id="breadCrumb" class="breadCrumb module">
            
            <ul >
            <?php foreach ($breadcrumb as $bc) { ?>
                <li>
                    <a href="<?php echo $bc['href'];?>"><?php echo $bc['title'];?></a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>