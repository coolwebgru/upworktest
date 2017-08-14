<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class TestController extends AppController
{

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */

    public function test()
    {
        // echo($this->request->testId);

        $catQuery = TableRegistry::get('Category');
        $category = $catQuery->get($this->request->testId);

        $this->set('category', $category);
        
    }

    public function testing()
    {
        // $catQuery = TableRegistry::get('Category');
        // $category = $catQuery->get($this->request->testId);

        $session = $this->request->session();
        $quizQuery = TableRegistry::get('Questions');
        $questions = $quizQuery->find('all', [
                'conditions' => ['category_id' => ($this->request->testId)]
            ]);
        $questionsArray = $questions->toArray();
        $session->write('questionCount', count($questionsArray));

        if($this->request->is('post')){
            $this->next($questionsArray);

            $questionId = $session->read('questionId');
        } else {
            $questionId = 0;
            $session->write('questionId', $questionId);
            $session->write('correctAnswers', 0);
        }

        

        if (count($questionsArray) > $questionId) {
            $this->set('questions', $questionsArray);
            $this->set('questionId', $questionId);
            $this->set('categoryId', $this->request->testId);

            $answerQuery = TableRegistry::get('Answer');
            $answers = $answerQuery->find('all', [
                'conditions' => ['question_id' => ($questionsArray[$questionId]->id)]
            ]);
            $answersArray = $answers->toArray();

            $this->set('answers', $answersArray);
        }
        else 
        {
            $correctAnswers = $session->read('correctAnswers');

            $this->redirect("/test/".$this->request->testId."/finish");
        }
            
    }

    public function next($questionsArray)
    {
        $session = $this->request->session();
        
        $selectedAnswerId = $this->request->data['answer_radio'];

        $questionId = $session->read('questionId');
        $correctAnswers = $session->read('correctAnswers');

        $answerQuery = TableRegistry::get('Answer');
        $selectedAnswer = $answerQuery->find('all', [
            'conditions' => ['id' => $selectedAnswerId]
            ]);
        $answersArray = $selectedAnswer->toArray();

        var_dump($answersArray[0]);
        if ($answersArray[0]->value) {
            $correctAnswers++;
            $session->write('correctAnswers', $correctAnswers);
        }

        $questionId++;
        $session->write('questionId', $questionId);


    }

    public function testFinish()
    {
        $session = $this->request->session();

        $questionCount = $session->read('questionCount');
        $correctAnswers = $session->read('correctAnswers');

        $this->set('questionCount', $questionCount);
        $this->set('correctAnswers', $correctAnswers);
    }

    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
