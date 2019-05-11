<?php 
    include ROOT.'/views/layouts/header.php';
?>
	<div class="container " style="margin-top: 100px;">
		<div class="row">
		
			<div class="col-md-8 col-md-offset-2">
				<h3>
					Привет Админ
				</h3>
                                <p><a href="/admin/add-group/">Добавить группу</a></p>
				<p><a href="/admin/add-student/">Добавить студента</a></p>
				<p><a href="/admin/add-teacher/">Добавить преподавателя</a></p>
                                <p><a href="/admin/add-lesson">Добавить предмет</a></p>
				<p><a href="/admin/add-admin/">Добавить администратора</a></p>
				
			</div>
			
			

		</div>		
		<div class="row" style="margin-top: 50px;">
		
		
			
			<div class="col-md-8 col-md-offset-2">
				<h3>Обзор посещяемости студентов</h3>
				<p>1-курс</p> 
				<p>2-курс</p>
				<p>3-курс</p>
				<p>4-курс</p>
			</div>	

		</div>		
	</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
  <script src="/template/js/jquery-3.1.1.js"></script>  
  <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/template/js/bootstrap.js"></script>
  </body>
</html>