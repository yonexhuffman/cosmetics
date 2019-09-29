<input type="hidden" id="page_offset_num" value="0">
<input type="hidden" id="keyword" value="<?php echo isset($keyword) ? $keyword : ''; ?>">
<div class="main">
  <div class="container">
    <div class="cosmetic-wrapper">            
      <div id="product-search-wrapper">
        <div class="search-box-left">
          <div class="search-box-left-btn search-button">
            <span class="search-text">成分</span>
          </div>
        </div>         
        <div class="search-box-right">
          <input id="search_form" type="text" autofocus="autofocus" value="<?php echo isset($keyword) ? $keyword : ''; ?>" placeholder="搜索 <?php echo isset($ingredient_total_count) ? $ingredient_total_count : ''; ?> 成分" tname="product">
        </div>
        <div class="search-box-button" id="btn_search">
            <img class="" src="<?php echo base_url('uploads/bg/search-icon-ccc.png')?>">
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="ingredient_panel">
          <ul id="productlist">
          <?php
              if (count($ingredient_list) > 0) {
                  $i = 1;
                  foreach ($ingredient_list as $key => $ingredient) {
                      if (empty($ingredient['ing_name'])) {
                          continue;
                      }
                      $security_risk_output = '';
                      if (!empty($ingredient['ing_security_risk'])) {
                          $security_risk = explode('-', $ingredient['ing_security_risk']);
                          $max = intval($security_risk[count($security_risk) - 1]);
                          if ($max > 7) {
                              $security_risk_output = '<span class="label label-danger security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                          }
                          else if ($max < 8 && $max >= 3) {
                              $security_risk_output = '<span class="label label-warning security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                          }
                          else {
                              $security_risk_output = '<span class="label label-primary security_risk_label">' . $ingredient['ing_security_risk'] . '</span>';
                          }
                      }
          ?>
              <li class="product_item">
                  <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient['ing_id'])?>">
                      <div class="row">
                          <div class="col-sm-5 col-md-5">
                              <p><?=$ingredient['ing_name']?></p>
                          </div>
                          <div class="col-sm-2 col-md-2">
                          <?php
                            if (!empty($security_risk_output)) {
                              echo "<p>安全风险 : " . $security_risk_output . " </p>";
                            }
                          ?>
                          </div>
                          <div class="col-sm-5 col-md-5">
                          <?php
                            if (!empty($security_risk_output)) {
                              echo "<p>使用目的 : " . $ingredient['ing_usage_purpose'] . " </p>";
                            }
                          ?>
                          </div>
                      </div>
                  </a>
              </li>
          <?php
                      $i ++;
                  }
              }
              else {
                  echo "<li style='text-align:center;font-size:20px;'>没有结果</li>";
              }
          ?>
          </ul>  
          <div class="row">
              <div class="col-md-12 text-center more-box">
                  <button class="btn more-btn cosmetic-btn" id="loadMoreData_btn">查看更多</button>
              </div>
          </div>
      </div>  
    </div>  
  </div>
</div>