<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        define('APP_NAME', 'incursophp');
        define('SUPERADMIN', 1);
        define('ADMIN', 2);
        define('PROFESSOR', 3);
        define('STUDENT', 4);
        
        
        $PT_LABELS = [
            'id'=>'id',
            'name'=>'Nome',
            'email'=>'Email',
            'password'=>'Senha',
            'role'=>'Papel',
            'company_id'=>'Empresa',
            'isActive'=>'Ativo',
            'isOnline'=>'Online',
            'moderatorPW'=>'Senha de Moderador',
            'attendeePW'=>'Senha de Visitante',
            'meetingID'=>'Id do encontro',
            'address'=>'Endereço',
            'description'=>'Descrição',
            'server_id'=>'Servidor',
            'ip'=>'Ip',
            'secret'=>'Segredo',
            'title'=>'Título',
            'text'=>'Texto',
            'Companies'=>'Empresas',
            'Courses'=>'Cursos',
            'News'=>'Notícias',
            'Servers'=>'Servidores',
            'Users'=>'Usuários',
            'delete'=>'Apagar',
            'view'=>'Ver',
            'edit'=>'Editar',
            'add'=>'Adicionar',
            'code'=>'Código'
        ];
        $this->set(compact('PT_LABELS'));
        
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display'
            ]
        ]);
         // Allow the display action so our pages controller
        // continues to work.
        $this->Auth->allow(['display']);
        $this->viewBuilder()->layout('dashboard');
    }

    
    public function beforeFilter(Event $event)
    {
        $this->set('title','');
        parent::beforeFilter($event);
        // debug($this->request);
    }

    public function sendEmail($subject,$message,$to,$flash=false)
    {
        $email = new Email('default');
        if (is_string($to)) {
            $email->to($to);
        }
        else if (is_array($to)) {
            foreach ($to as $value) {
                $email->addTo($value);
            }
        }
        if ($email->emailFormat('both')->from(['contato@incur.so' => 'InCurso'])->subject($subject)->send($message)) {
            if($flash)
                $this->Flash->success('Mensagem enviada com sucesso!');
        }
        else{
            if($flash)
                $this->Flash->error('Não foi possível enviar a mensagem. Por favor, tente mais tarde.');
        }
    }
}
