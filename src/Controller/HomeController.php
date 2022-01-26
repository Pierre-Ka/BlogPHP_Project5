<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\User;
/*
use BlogApp\Entity\Post;
use BlogApp\Entity\Category;
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;
*/
class HomeController extends AbstractController
{
	public function home()
	{
		$categories_header = $this->categoryManager->getAll();
		require '../template/home/home.php' ;
	}


	public function post()
	{
		$categories_header = $this->categoryManager->getAll();
		$q_total=$this->postManager->totalPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$posts=$this->postManager->getAll($actual_page);
		require('../template/home/post.php');
	}	

	public function category()
	{
		$categories_header = $this->categoryManager->getAll();
		$category_id=htmlspecialchars($_GET['id']);
		$category = $this->categoryManager->getOne($category_id);
		$q_total=$this->postManager->totalPagesByCategory($category_id);
			
		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
			{
				$actual_page =intval($_GET['page']);
			}
		else 
			{
				$actual_page = 1 ;
			}
		$posts=$this->postManager->getWithCategory($category_id,$actual_page);
		require('../template/home/category.php');
	}	

	public function single()
	{
		$categories_header = $this->categoryManager->getAll();
		$post_id= $_GET['id'];
		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'post_id'=> $post_id,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$this->commentManager->add($comment);
		}

		$post=$this->postManager->getOne($post_id);
		$q_total=$this->commentManager->totalPages($post_id);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$comments = $this->commentManager->get($post_id,$actual_page);
		require('../template/home/single.php');
	}	


	public function sign_in()
	{
		$categories_header = $this->categoryManager->getAll();
		$incorrect=false;
		if (!empty($_POST['email']) AND !empty($_POST['password']))
		{
			$logged = $this->userManager->login($_POST['email'], $_POST['password']);
			if($logged)
			{			
				header('Location:index.php?p=user.home');
			}
			else
			{
				$incorrect=true;
				require('../template/home/sign_in.php');
			}
		}
		if ( isset($_POST['emailCreate']) AND !empty($_POST['emailCreate']) AND
			isset($_POST['nameCreate']) AND !empty($_POST['nameCreate']) AND
			isset($_POST['passwordCreate']) AND !empty($_POST['passwordCreate']) AND
			isset($_POST['passwordConfirm']) AND !empty($_POST['passwordConfirm']) AND
			isset($_POST['descriptionCreate']) AND !empty($_POST['descriptionCreate']))
		{
			if (($_POST['passwordCreate'])===($_POST['passwordConfirm']))
			{
				if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['emailCreate']))
				{
					$user = new User([
					'email'=> htmlspecialchars($_POST['emailCreate']),
					'password'=> htmlspecialchars($_POST['passwordConfirm']),
					'name'=> htmlspecialchars($_POST['nameCreate']),
					'description'=> htmlspecialchars($_POST['descriptionCreate'])
					]);
					$this->userManager->add($user);
					$message = 'enregistrement reussi';
					require('../template/home/sign_in.php');
				}
				else
				{
					$incorrect=true;
					require('../template/home/sign_in.php');
				}
			}
			else
			{
				$incorrect=true;
				require('../template/home/sign_in.php');
			}
		}
		else 
		{
			require('../template/home/sign_in.php');
		}
	}
}

