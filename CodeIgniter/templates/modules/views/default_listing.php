<div id="propertilist">
	<h2>Listing Properti</h2>
	
	<div class="controlbox">
		<?=$sorting_form?>
	</div>
	
                
	<ul class="list">
		<?php 
			$language = 'id';
			foreach($list_all as $la): 
			$la['ads_id'] = substr($la['id'], 3);
			//format image url
			$ads_image = !empty($la['image'])?$la['image']:'';
			$imgURL = formatImageURL($la['ads_id'], $la['type'], $la['category'], $ads_image);
			
			//format currency & price
			$ads_period = !empty($la['period'])?$la['period']:'';
			if ($ads_period == 'Yearly') {
				//$period = $la->ads_period;
				$period = '/tahun';
			}
			else if ($ads_period == 'Monthly') {
				$period = ucwords($this->lang->line('monthly'));
			}
			else if ($ads_period == 'Daily') {
				$period = '/hari';
			}
			else {
				$period = "";
			} 
			$price = convertCurrencyType($la['currency'], $la['idr_price'], $la['price'], $ads_period);
			if($la['currency'] == 'IDR')
				$price['price'] = number_format($la['idr_price']);
			else
				$price['price'] = number_format($la['price']);
				
			//format deskripsi & tagline
			$deskripsi = !empty($la['description'])?filterOddCharacter($la['description']):'';
			$tagline = !empty($la['tagline'])?filterOddCharacter($la['tagline']):'';
			
			//format detil URL
			$detilURL = formatDetailURL($la['ads_id'], $la['type'], $la['category'], $la['district_name'], $la['city_name'], $language);
			
			//format company
			$company_logo_url = !empty($la['user']['company_logo'])?$this->config->item('img_url').'logo/thumbnail/'.$la['user']['company_logo']:$this->config->item('img_url').'logo/thumbnail/';
		?>
			<li>
				<img class="listimg" src="<?=$imgURL?>" width="220" height="165" />
                      <div class="listdesc">
                        <h3> Rumah <?=ucwords(convertPropertyCategory($params = $la['category'], $lang = $language))?> di <?=ucwords($la['district_name'])?>, <?=ucwords($la['city_name'])?></h3>
                        <span><?=$la['currency'];?> <?=$price['price']?>&nbsp;<?=$period?></span>
                        <p> <?=Snippet($deskripsi, 90)?></p>
                        <a class="button" onclick="countThis('house', '<?=$la['ads_id']?>',this); return false;" href="<?=$detilURL?>">Lihat Detil</a>
                      </div>
                      <div class="listinfo">
                        <img src="<?=$company_logo_url?>" />
                        <table>
                          <tbody>
                            <tr title="Luas tanah"><td>L</td><td>: <?=str_replace('.00', '', $la['land_size'])?>m<sup>2</sup></td></tr>
                            <tr title="Kamar tidur"><td>KT</td><td>: <?=$la['bedroom']?></td></tr>
                            <tr title="Kamar mandi"><td>KM</td><td>: <?=$la['bathroom']?></td></tr>
                            <tr title="Garasi"><td>G</td><td>: <?=$la['garage']?></td></tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="clear"></div>
			</li>
		<?php endforeach; ?>  

	</ul>
	<div class="paging">
		<ul>
			<?=$pagination?>
		</ul>
		<div class="clear"></div>
	</div>
</div>