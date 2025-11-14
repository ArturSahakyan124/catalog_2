<?php
/* Smarty version 5.6.0, created on 2025-11-13 23:21:56
  from 'file:carList.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_69165a04643f95_03647959',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '265f387b194a5e7a9912d2dc1a5b3eb790acb51a' => 
    array (
      0 => 'carList.tpl',
      1 => 1763072507,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69165a04643f95_03647959 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\less\\project\\views\\templates';
?>    <template id="car-card-template">
  <link rel="stylesheet" href="../assets/css/main.css">
  <link rel="stylesheet" href="../assets/css/profile.css">
  <div class="product-box">
    <img class="product-img" src="" alt="Photo">
    <div class="product-info">
      <div class="product-title">
        <div class="car-name"></div>
        <div class="model"></div>
      </div>
      <div class="product-details">Year: </div>
      <div class="car-id">ID: </div>
      <div class="car-user">User: </div>
    </div>
    <div class="product-btns-container" style="display: none;">
      <button class="product-btns edit-btn primary-btn">Edit</button>
      <button class="product-btns delete-btn secondary-btn">Delete</button>
    </div>
  </div>
</template>

    
    
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('cars'), 'car');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('car')->value) {
$foreach0DoElse = false;
?>
    <car-card
        photo="../assets/<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['photo'], ENT_QUOTES, 'UTF-8', true);?>
"
        name="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['name'], ENT_QUOTES, 'UTF-8', true);?>
"
        model="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['model'], ENT_QUOTES, 'UTF-8', true);?>
"
        year="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['year'], ENT_QUOTES, 'UTF-8', true);?>
"
        id="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['id'], ENT_QUOTES, 'UTF-8', true);?>
"
        username="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('car')['username'], ENT_QUOTES, 'UTF-8', true);?>
"
        editable="<?php if ($_smarty_tpl->getValue('user_id') == $_smarty_tpl->getValue('car')['user_id']) {?>true<?php } else { ?>false<?php }?>">
    </car-card>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
