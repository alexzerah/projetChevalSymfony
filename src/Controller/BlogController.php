<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return new Response('
           <html>
            <body>
                <h1 style="text-align: center;font-family: sans-serif;padding-top: 150px;">Welcome to the HomePage!</h1>
            </body>
           </html>');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(Request $request)
    {
        $name = $request->query->get('name');

        return $this->render('blog.html.twig', [
            'blog_title' => 'Mon super blog',
            'name' => $name,
        ]);
    }

    /**
     * @Route("/hello/{name}/{age}", name="hello", defaults={"age"=null})
     */
    public function hello($name, $age)
    {
        return $this->render('hello.html.twig', [
            'name' => $name,
            'age' => $age
        ]);
    }


    /**
     * @Route("/math/{a}/{b}", name="math")
     */
    public function math($a, $b, Calculator $calculator)
    {
        //$calc = Calculator::add($a, $b);
        $result = $calculator->add($a, $b);

        return $this->render('math.html.twig', [
            'a' => $a,
            'b' => $b,
            'result' => $result
        ]);
    }

    /**
    * @Route("/post", name="post")
    */
    public function post(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();

        return $this->render('post.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("blog/post/new", name="new_blog_post")
     */
    public function newPost(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        return $this->render('new_blog_post.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
