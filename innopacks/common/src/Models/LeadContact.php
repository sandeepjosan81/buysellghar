<?php


namespace InnoShop\Common\Models;

class LeadContact extends BaseModel
{
    protected $table = 'lead_contacts';

    protected $fillable = [
        'product_id','name', 'contact_no', 'email', 'property_url', 'interested_in', 'status',
    ];
    
}
