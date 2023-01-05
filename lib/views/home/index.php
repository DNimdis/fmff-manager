<div class="container">
<form 
    action="" 
    data-sm-action="<?php echo SmRouterHelper::build_route_name('settings', 'save_variables'); ?>"
    >
    <div class="card" style=" max-width: 100%; padding: 0;" >
        <div class="card-header">
            <i class="fa fa-cogs"></i> Setting
        </div>
        <div class="card-body">
            <h3 class="os-sub-header"><?php _e('API Keys', 'latepoint-payments-stripe'); ?></h3>
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="full_name"> Secret Key </label>
                    <input type="password" class="form-control" id="full_name"  value="<?php echo SmSettingsHelper::get_settings_value('stripe_secret_key');?>"  name="settings[stripe_secret_key]" aria-describedby="settings[stripe_secret_key]" placeholder=" ********" >                    
                </div>
                <div class="form-group col-sm-6">
                    <label for="number"> Publishable Key </label>
                    <input type="text" class="form-control" id="number" value="<?php echo SmSettingsHelper::get_settings_value('stripe_publishable_key');?>" name="settings[stripe_publishable_key]" aria-describedby="number" placeholder="**********" >                    
                </div>
            </div>
            
        </div>
        <div class="card-footer">
            <div class="os-form-buttons">
                <?php echo OsFormHelper::button('submit', __('Save Settings', 'latepoint'), 'submit', ['class' => 'btn btn-outline-secondary'], 'latepoint-icon-checkmark'); ?>
            </div>        
        </div>        
        </div>

</form>
    </div>
</div>