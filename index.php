<?php
include('base.php');
include('action.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $header ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JRMFPKGDRS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JRMFPKGDRS');
</script>
<script data-ad-client="ca-pub-9389089850784229" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
    <div class="pop-alert">
        <div class="pop-container"></div>
    </div>
    <?php echo $top ?>
    <div class="b-search">
        <div class="search">
            <?php
                while($row = $result_menu->fetch()) {
                    echo '<div class="s-social" data-s='.$row["name"].'><img src="style/img/'.$row["icon"].'"/>'.$row["name"].'</div>';
                }
            ?>
        </div>
        <div class="s-table">
            <div class="s-t-container">
                <div class="s-t-all"><img src="style/img/dot.png"/><div class="r-social"></div></div>
                <div class="s-t-c-container"></div>
            </div>
        </div>
        <div class="s-filter">
            <div class="s-f-container">
                <div class="s-f-name">Social Media</div>
                <div class="s-f-select" data-id="sm">
                    <div class="s-f-text" data-id="sm"></div>
                    <div class="s-f-icon"><img src="style/img/down.png"/></div>
                </div>
                <div class="s-f-dropdown" data-id="sm">
                    <?php
                        while($row = $result_menu_s->fetch()) {
                            echo '<div class="s-f-name s-f-n-drop" data-id="'.$row["name"].'">'.$row["name"].'</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="s-f-container">
                <div class="s-f-name">Category</div>
                <div class="s-f-select" data-id="c">
                    <div class="s-f-text" data-id="c">-</div>
                    <div class="s-f-icon"><img src="style/img/down.png"/></div>
                </div>
                <div class="s-f-dropdown" data-id="c">
                    <li class="s-f-name s-f-n-drop" data-id="All">All</li>
                </div>
            </div>
            <div class="s-f-container">
                <div class="s-f-name">Country/Language</div>
                <div class="s-f-select" data-id="cl">
                    <div class="s-f-text" data-id="cl">-</div>
                    <div class="s-f-icon"><img src="style/img/down.png"/></div>
                </div>
                <div class="s-f-dropdown" data-id="cl">
                    <li class="s-f-name s-f-n-drop" data-id="All">All</li>
                </div>
            </div>
            <div class="s-f-container">
                <div class="s-f-name">Follow/Subscription/People</div>
                <div class="s-f-select" data-id="f">
                    <div class="s-f-text" data-id="f">-</div>
                    <div class="s-f-icon"><img src="style/img/down.png"/></div>
                </div>
                <div class="s-f-dropdown" data-id="f">
                    <li class="l-select-drop s-f-n-drop" data-id="All">All</li>
                    <li class="l-select-drop s-f-n-drop" data-id="1">0 - 1k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="2">1k - 5k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="3">5k - 10k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="4">10k - 50k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="5">50k - 100k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="6">100k - 500k</li>
                    <li class="l-select-drop s-f-n-drop" data-id="7">500k - 1m</li>
                    <li class="l-select-drop s-f-n-drop" data-id="8">> 1m</li>
                </div>
            </div>
            <div class="s-f-container">
                <div class="s-f-name">Verified</div>
                <div class="s-f-select" data-id="v">
                    <div class="s-f-text" data-id="v">-</div>
                    <div class="s-f-icon"><img src="style/img/down.png"/></div>
                </div>
                <div class="s-f-dropdown" data-id="v">
                    <li class="l-select-drop s-f-n-drop">All</li>
                    <li class="l-select-drop s-f-n-drop" data-id="1">Yes</li>
                    <li class="l-select-drop s-f-n-drop" data-id="0">No</li>
                </div>
            </div>
        </div>
    </div>
    <div class="promo-container"></div>
    <div class="p-a-text">Recommended</div>
    <div class="p-links">
        <?php
        $row_f = $result_user_data_followed->fetch();
        $followed_id = explode('/', $row_f['followed']);
        $data_id = '';
        while($row = $result_promolinks ->fetch()) {
            foreach ($followed_id as $value) {
                if ($value == $row['id']) {
                    $data_id = 'on';
                    break;
                } else {
                    $data_id = 'off';
                }
            }
            echo '
                <div class="p-box" data-id="' . $row['id'] . '" data-s="' . $row['social'] . '">
                    <div class="p-l-img" style="margin-top:10px;">
                        <img src="../style/img/upload/' . $row['image'] . '"/>
                        <div class="p-l-icon">
                            <img src="../style/img/img_' . $row['social'] . '.png"/>
                        </div>
                    </div>
                    <div class="p-text-title" style="margin-top: 20px; font-weight:600;">' . $row['title'] . '</div>
                    <div class="p-text-subtitle" style="font-size:0.7rem;">' . $row['subtitle'] . '</div>
                    <div class="p-text" style="font-size:1rem;"><img src="style/img/crowd.png"/>' . $row['ammount'] . '</div>
                    <div class="p-text" style="font-size:0.7rem;margin-bottom:20px;">#' . $row['category1'] . ' #' . $row['category2'] . ' #' . $row['category3'] . '
                        <div class="p-love" data-id="' . $row['id'] . '" data-f="' . $data_id . '"></div>
                    </div>
                </div>';
        }
        ?>
    </div>
    <div class="container" data-category="none"></div>
    <div class="b-m-title">Partners</div>
    <div class="b-more">
        <a target="_blank" href="https://icons8.com">
            <div class="b-m-partners">
                <img src="style/img/partners/icons8.png"/>
                All icons by Icons8
            </div>
        </a>
    </div>
    <?php echo $footer ?>
</body>
</html>