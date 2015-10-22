<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('title','Usuários');
        $this->Auth->allow(['login','logout','add','recovery','resetPW','contact']);
    }

    
    
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conditions = [];
        $conditions['Users.id']=$id;
        $user = $this->Users->find('all', [
            'conditions' => $conditions
        ]);
        $user = $user->first();
        if (!$user) {
            throw new \Cake\Network\Exception\NotFoundException("Não foi possível encontrar esse usuário.");
        }
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
                if (!preg_match('/[A-Za-z0-9]{6,8}/', $this->request->data['password'])) {
                    $this->Flash->error('Senha inválida. A senha deve ser composta de números e/ou letras, e ter de 6 a 8 caracteres.');
                    $this->request->data['password'] = null;
                }
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('O usuário não pôde ser salvo(a). Por favor, tente novamente.'));
                }
            
        }
        $roles = [4=>'ESTUDANTE',3=>'PROFESSOR',2=>'ADMINISTRADOR'];
        
            $roles[1] = 'SUPERADMIN';
        
        $this->set(compact('user','roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $conditions = [];
        $conditions['Users.id']=$id;
        $user = $this->Users->find('all', [
            'contain' => ['Companies'],
            'conditions' => $conditions
        ]);
        $user = $user->first();
        if (!$user) {
            throw new \Cake\Network\Exception\NotFoundException("Não foi possível encontrar esse usuário.");
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $hasher = new DefaultPasswordHasher();
            if (isset($this->request->data['confirmPassword']) && !$hasher->check($this->request->data['confirmPassword'],$user['password'])) {
                $this->Flash->error(__('Senha não confere.'));
            }
            else{
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('O usuário foi salvo com sucesso.'));
                    return $this->redirect(['action' => 'view',$id]);
                } else {
                    $this->Flash->error(__('O usuário não pôde ser salvo(a). Por favor, tente novamente.'));
                }
            }
            
        }
        $roles = [4=>'ESTUDANTE',3=>'PROFESSOR',2=>'ADMINISTRADOR'];
            $roles[1] = 'SUPERADMIN';
        $this->set(compact('user','roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('O usuário foi deletado com sucesso.'));
        } else {
            $this->Flash->error(__('O usuário não pôde ser deletado. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        // debug($this->request->session()->read());
        if ($this->request->session()->read('Auth.User.id')) {
            $this->redirect('/');
        }
        $this->viewBuilder()->layout('default');
        if ($this->request->is('post')) {
            // debug($this->request->data);
            $user = $this->Auth->identify();
            if ($user) {
                $this->Flash->success('Bem vindo, '.$user['name'].'!',['params'=>['emitUserOnline'=>$user['id']]]);
                $this->Auth->setUser($user);
                if ($user['role']=='1') {
                    $redirect = ['controller'=>'companies'];
                }
                else if($user['role']=='2'){
                    $redirect = ['action'=>'index'];
                }
                else 
                    $redirect = ['controller'=>'news'];    
                return $this->redirect($redirect);
            }
            $this->Flash->error('Email e/ou senha incorretos.');
        }
    }

    public function logout()
    {
        $this->Flash->success('Logout feito com sucesso. Até a próxima!');
        return $this->redirect($this->Auth->logout());
    }

    public function password()
    {
        $id = $this->request->session()->read('Auth.User.id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->get($id);
            $hasher = new DefaultPasswordHasher();
            if ($this->request->data['password']!=$this->request->data['repeatPassword']) {
                $this->Flash->error('Senha repetida não confere.');
            }
            else if (!preg_match('/[A-Za-z0-9]{6,8}/', $this->request->data['password'])) {
                $this->Flash->error('Nova senha inválida. A senha deve ser composta de números e/ou letras, e ter de 6 a 8 caracteres.');    
            }
            else if (!$hasher->check($this->request->data['oldPassword'],$user['password'])) {
                // debug($hasher->check($this->request->data['oldPassword'],$user['password']));
                $this->Flash->error('Senha antiga não confere.');
            }
            else{
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Nova senha definida com sucesso.'));
                    return $this->redirect(['action' => 'view']);
                } else {
                    $this->Flash->error(__('A senha não pôde ser salva. Por favor, tente novamente.'));
                }
            }
        }
    }

    public function resetPW($token)
    {
        if ($this->request->session()->read('Auth.User.id')) {
            return $this->redirect('/');
        }

        $this->viewBuilder()->layout('default');

        if ($this->request->is(['post'])) {
            $user = $this->Users->get($this->request->data['id']);
            if ($this->request->data['password']!=$this->request->data['repeatPassword']) {
                $this->Flash->error('Senha repetida não confere.');
            }
            else if (!preg_match('/[A-Za-z0-9]{6,8}/', $this->request->data['password'])) {
                $this->Flash->error('Nova senha inválida. A senha deve ser composta de números e/ou letras, e ter de 6 a 8 caracteres.');    
            }
            else{
                unset($this->request->data['repeatPassword']);
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Nova senha definida com sucesso.'));
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('A senha não pôde ser salva. Por favor, tente novamente.'));
                }
            }
        }
    
        $strs = explode('-', $token);
        $intervalMin = (time() - $strs[0])/60;
        // debug($intervalMin);
        if ($intervalMin > 60) {
            $this->Flash->error('Desculpe, esse link está expirado!');
            return $this->redirect('/');
        }
        else{
            $user = $this->Users->find('all',['conditions'=>['Users.token'=>$token]]);
            $user = $user->first();
            if (!$user) {
                $this->Flash->error('Link inválido!');
                return $this->redirect('/');
                # code...
            }
        }

        $this->set(compact('user'));    
        
    }

    public function recovery()
    {
        $this->viewBuilder()->layout('default');
        // debug();
        if ($this->request->is('post')) {
            $user = $this->Users->find('all',['conditions'=>['email'=>$this->request->data['email']]]);
            $user = $user->first();
            // debug($user);
            if ($user) {
                $usersTable = TableRegistry::get('Users');
                $user->token = time().'-'.uniqid(mt_rand(), true);
                $save = $usersTable->save($user);
                $email = new Email('default');
                $message = 'Foi recebido um pedido de redefinição de senha para o email '.$user['email'].'.<br>';
                $message.= 'Se você não solicitou essa redefinição, por favor ignore esse email.<br>';
                $message.= 'Caso tenha solicitado essa redefinição, por favor clique ';
                $message.= '<a href="'.Router::url( '/', true ).'users/resetPW/'.$user->token.'">aqui</a> para definir uma nova senha.';
                if ($save && $email->emailFormat('both')->from(['contato@incur.so' => 'InCurso'])->to($user['email'])->subject('Redefinição de senha')->send($message)) {
                    $this->Flash->success('Um email com instruções de como redefir sua senha foi enviado para '.$user['email'].'.');
                }
                else
                    $this->Flash->error('Erro ao enviar email. Por favor, contate o administrador.');
            }
            else{
                $this->Flash->error('Usuário não encontrado!');
            }
        }
    }

    public function contact()
    {
        if ($this->request->is('post')) {
            // debug($user);
            if (isset($this->request->data['email']) && isset($this->request->data['message'])) {
                $email = new Email('default');
                $message = 'De:<br>'.$this->request->data['email'].'<br>';
                $message.= 'Empresa:<br>'.$this->request->data['company'];
                $message.= 'Telefone:<br>'.$this->request->data['phone'];
                $message.= 'Mensagem:<br>'.$this->request->data['message'];
                if ($email->emailFormat('both')->from(['contato@incur.so' => 'InCurso'])->to('contato@incur.so')->subject('Contato - '.$this->request->data['subject'])->send($message)) {
                    $this->Flash->success('Mensagem enviada com sucesso!');
                }
                else
                    $this->Flash->error('Não foi possível enviar a mensagem. Por favor, tente mais tarde.');
            }
            else{
                $this->Flash->error('Não foi possível enviar a mensagem. Por favor, tente novamente.');
            }
        }
        $this->redirect('/');
    }

    public function notifications() {
        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Configurãções salvas com sucesso.'));
                return $this->redirect(['action' => 'view',$this->request->session()->read('Auth.User.id')]);
            } else {
                $this->Flash->error(__('Configurãções não foram salvas. Por favor, tente novamente.'));
            }
            
        }
        $this->set(compact('user'));
    }
}
