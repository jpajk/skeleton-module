{if $listings}
	{foreach from=$listings item=listing}		
		<h3>{$listing.title_listing}</h3>
		{if $listing.listing_items}
			<ul>
				{foreach from=$listing.listing_items item=listing_item}
					<li>{$listing_item}</li>	
				{/foreach}				
			</ul>
		{/if}
	{/foreach}
{/if}