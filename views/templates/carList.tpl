    <template id="car-card-template">
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

    
    
    {foreach $cars as $car}
    <car-card
        photo="../assets/{$car.photo|escape}"
        name="{$car.name|escape}"
        model="{$car.model|escape}"
        year="{$car.year|escape}"
        id="{$car.id|escape}"
        username="{$car.username|escape}"
        editable="{if $user_id == $car.user_id}true{else}false{/if}">
    </car-card>
    {/foreach}
