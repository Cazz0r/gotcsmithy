            </div>
        </main>
        <footer class="text-muted">
            <div class="container">
                <p class="float-left">
                    <abbr title="I have to update this every kingdom merge, don't I?">Cazz of ECXES, Kingdom 550</abbr>
                </p>
                <p class="float-right">
                    <a href="#">Back to top</a>
                </p>

            </div>
        </footer>
    </div>
	<!-- Modal -->
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modaltitle">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Hello World
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js" integrity="sha256-FiZwavyI2V6+EXO1U+xzLG3IKldpiTFf3153ea9zikQ=" crossorigin="anonymous"></script>

	<script language="javascript">
		$(document).ready(function(){
            //Universal
			$('[data-toggle="tooltip"]').tooltip();
			$("#modal").on('shown.bs.modal', function(e){
				$('[data-toggle="tooltip"]').tooltip();
			});
            
            var clipboard = new ClipboardJS('.copy');
            
			Bindings();
		});
        function Bindings(){
            $('.Show-Detail').unbind().click(function(){
                var level = $(this).attr('data-level');
                
                console.log('Show: ' + level);
                $('.Items-' + level).toggle();
            });
            $('#QualitySelect').unbind().change(function(){
                var quality = $('#QualitySelect').val();
                console.log('Hide: ' + quality);
                $('.QualityInput').show();
                $('.QualityInput-' + quality).hide();
            });
            $('.advanced-materials-controller .btn').unbind().click(function(){
                $('.advanced-materials-container').show();
                $('.advanced-materials-controller').hide();
            });
            
            $('#LunaQuality').unbind().change(function(){
                var quality = $('#LunaQuality').val();
                $('.Quality-Container').hide();
                $('.Quality-' + quality).show();
            });
            
            $('.QualityInput').unbind().keypress(function(e){
                var quality = $(this).attr('data-quality');
                console.log(e.keyCode); 
                if(e.keyCode == 13){
                    $('#QualityInputGo-' + quality).click();
                    return false;
                }
            });
            $('.Quality-Calculate').unbind().click(function(){
                var quality = $(this).attr('data-quality');
                if($(this).val()=='Reset') $('#QualityInput-' + quality).val('');
                var quantity = $('#QualityInput-' + quality).val();
                
                console.log('Quality: ' + quality);
                console.log('Quantity: ' + quantity);
                
                if(quantity == '') quantity = 1;
                if(quantity < 0) quantity = 1;
                
                $('.QualityLabel-' + quality).html(quantity);
                
                $('.Quantity-' + quality + '-Poor').html($('.Quantity-' + quality + '-Poor').attr('data-original') * quantity);
                $('.Quantity-' + quality + '-Common').html($('.Quantity-' + quality + '-Common').attr('data-original') * quantity);
                $('.Quantity-' + quality + '-Fine').html($('.Quantity-' + quality + '-Fine').attr('data-original') * quantity);
                $('.Quantity-' + quality + '-Exquisite').html($('.Quantity-' + quality + '-Exquisite').attr('data-original') * quantity);
                $('.Quantity-' + quality + '-Epic').html($('.Quantity-' + quality + '-Epic').attr('data-original') * quantity);
                $('.Quantity-' + quality + '-Legendary').html($('.Quantity-' + quality + '-Legendary').attr('data-original') * quantity); 
            });
            $('.Sum-Poor, .Sum-Common, .Sum-Fine, .Sum-Exquisite, .Sum-Epic, .Sum-Legendary').unbind().keypress(function(e){
               if(e.keyCode == 13){
                   $('#Quantity-Calculate').click();
                   return false;
               } 
            });
            $('.Quantity-Calculate').unbind().click(function(){
                
                if($(this).val()=='Go'){
                
                    if($('.Sum-Poor').val()=='') $('.Sum-Poor').val('0');
                    if($('.Sum-Common').val()=='') $('.Sum-Common').val('0');
                    if($('.Sum-Fine').val()=='') $('.Sum-Fine').val('0');
                    if($('.Sum-Exquisite').val()=='') $('.Sum-Exquisite').val('0');
                    if($('.Sum-Epic').val()=='') $('.Sum-Epic').val('0');
                    if($('.Sum-Legendary').val()=='') $('.Sum-Legendary').val('0');

                    $('.CouldBe-Poor').html(parseInt($('.Sum-Poor').val(), 10));
                    $('.CouldBe-Common').html( parseInt($('.Sum-Poor').val() / 4, 10) + parseInt($('.Sum-Common').val(), 10));
                    $('.CouldBe-Fine').html(parseInt($('.Sum-Poor').val() / 4 / 4, 10) + parseInt($('.Sum-Common').val() / 4, 10) + parseInt($('.Sum-Fine').val(), 10));
                    $('.CouldBe-Exquisite').html(parseInt($('.Sum-Poor').val() / 4 / 4 / 4, 10) + parseInt($('.Sum-Common').val() / 4 / 4, 10) + parseInt($('.Sum-Fine').val() / 4, 10) + parseInt($('.Sum-Exquisite').val(), 10));
                    
                    $('.CouldBe-Epic').html(parseInt($('.Sum-Poor').val() / 4 / 4 / 4 / 4, 10) + parseInt($('.Sum-Common').val() / 4 / 4 / 4, 10) + parseInt($('.Sum-Fine').val() / 4 / 4, 10) + parseInt($('.Sum-Exquisite').val() / 4, 10) + parseInt($('.Sum-Epic').val(), 10));
                    
                    $('.CouldBe-Legendary').html(parseInt($('.Sum-Poor').val() / 4 / 4 / 4 / 4 / 4, 10) + parseInt($('.Sum-Common').val() / 4 / 4 / 4 / 4, 10) + parseInt($('.Sum-Fine').val() / 4 / 4 / 4, 10) + parseInt($('.Sum-Exquisite').val() / 4 / 4, 10) + parseInt($('.Sum-Epic').val() / 4, 10) + parseInt($('.Sum-Legendary').val(), 10));

                    $('#Calculate-Results').show();
                }else{
                    $('.Sum-Poor').val('0');
                    $('.Sum-Common').val('0');
                    $('.Sum-Fine').val('0');
                    $('.Sum-Exquisite').val('0');
                    $('.Sum-Epic').val('0');
                    $('.Sum-Legendary').val('0');
                    
                    $('#Calculate-Results').hide();
                }
            });
            $('.Update-Materials').unbind().click(function(){
                var data = $(this).attr('data-materials');
                //console.log(data);
                var obj = tryParseJSON(data);
                if (obj !== false){
                    //console.log(obj);
                    
                    for(var key in obj){
                        console.log('Change Material: ' + key + ' [' + obj[key] + ']');
                        $('#' + key).val(obj[key]);
                    }
                    $(this).removeAttr('data-materials').addClass('disabled').attr('disabled', 'disabled').html('Materials Updated');
                }else{
                    console.log('Unable to subtract from materials.');
                }
            });
            $('.Prestige-Calculate').unbind().click(function(){
                if($(this).val()=='Reset'){
                    $('#current-prestige').val('');
                    $('.Prestige-Container').hide();
                }else{
                    $('.Prestige-Container').show();
                    var current = parseInt($('#current-prestige').val(), 10), house = $('#current-house').val(), prestige = $('#current-house').find(':selected').attr('data-prestige');
                    if(current == '') current = 1;
                    if(current < 0) current = 1;
                    
                    var togo = prestige - current;
                    
                    console.log('House: ' + house + ', Current: ' + current + ', Prestige: ' + prestige + ', To Go: ' + togo);    
                    
                
                    $('.House-Label').html(house);
                    $('.Prestige-Label').html(new Intl.NumberFormat().format(current) + '/' + new Intl.NumberFormat().format(prestige));
                    $('.Prestige-Table').find('tbody').find('tr').each(function(){
                        var level = $(this).attr('data-level'), cstam = $(this).attr('data-stam'), cxp = $(this).attr('data-xp');
                        console.log('Creature ' + level + ', XP ' + cxp + ', Stam ' + cstam + ', To Go ' + togo);
                        
                        creatures = Math.ceil(parseInt(togo, 10) / parseInt(cxp));
                        stamina = parseInt(creatures, 10) * parseInt(cstam, 10);
                        refills = Math.ceil(parseInt(stamina)/100);
                        gold = Math.ceil(parseInt(refills, 10)*700);
                        
                        $(this).find('.creatures').html(Intl.NumberFormat().format(creatures));
                        $(this).find('.stamina').html(Intl.NumberFormat().format(stamina));
                        $(this).find('.refills').html(Intl.NumberFormat().format(refills));
                        $(this).find('.gold').html(Intl.NumberFormat().format(gold));
                    });
                }
            });
        }
        function tryParseJSON (jsonString){
            try {
                var o = JSON.parse(jsonString);

                // Handle non-exception-throwing cases:
                // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
                // but... JSON.parse(null) returns null, and typeof null === "object", 
                // so we must check for that, too. Thankfully, null is falsey, so this suffices:
                if (o && typeof o === "object") {
                    return o;
                }
            }
            catch (e) { }

            return false;
        };
	</script>
	
</body>
</html>