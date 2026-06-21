<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);


$conn = mysqli_connect("localhost", "root", "", "websiteku");
if(!$conn){
    die("Koneksi database gagal: " . mysqli_connect_error());
}


function getAvatarColor($name){
    $palette = [
        '#F87171', '#FB923C', '#FBBF24', '#34D399', '#22D3EE',
        '#60A5FA', '#A78BFA', '#F472B6', '#818CF8', '#4ADE80'
    ];
    $index = crc32($name) % count($palette);
    return $palette[$index];
}


function renderPosts($conn, $current_username){
    $html = '';

    $sqlPost = "SELECT * FROM diskusi_post ORDER BY id DESC";
    $resPost = mysqli_query($conn, $sqlPost);

    if(!$resPost || mysqli_num_rows($resPost) === 0){
        return '<p class="empty-state">Belum ada postingan. Jadilah yang pertama bertanya!</p>';
    }

    while($post = mysqli_fetch_assoc($resPost)){
        $post_id        = (int)$post['id'];
        $post_username  = htmlspecialchars($post['username']);
        $post_isi       = nl2br(htmlspecialchars($post['isi']));
        $post_isi_raw   = htmlspecialchars($post['isi'], ENT_QUOTES);
        $like_count     = (int)$post['like_count'];
        $waktu          = date("d M Y, H:i", strtotime($post['created_at']));
        $isOwner        = ($post['username'] === $current_username);
        $post_initial   = strtoupper(substr($post['username'], 0, 1));
        $post_avatar_bg = getAvatarColor($post['username']);

        
        $stmtLiked = $conn->prepare("SELECT COUNT(*) FROM diskusi_like WHERE post_id = ? AND username = ?");
        $stmtLiked->bind_param("is", $post_id, $current_username);
        $stmtLiked->execute();
        $stmtLiked->bind_result($likedCount);
        $stmtLiked->fetch();
        $stmtLiked->close();
        $hasLiked = $likedCount > 0;

        
        $sqlKomentar = "SELECT * FROM diskusi_komentar WHERE post_id = $post_id ORDER BY id ASC";
        $resKomentar = mysqli_query($conn, $sqlKomentar);
        $jumlahKomentar = mysqli_num_rows($resKomentar);

        $komentarHtml = '';
        while($k = mysqli_fetch_assoc($resKomentar)){
            $k_username  = htmlspecialchars($k['username']);
            $k_isi       = nl2br(htmlspecialchars($k['isi']));
            $k_initial   = strtoupper(substr($k['username'], 0, 1));
            $k_avatar_bg = getAvatarColor($k['username']);
            $komentarHtml .= '
            <div class="comment-item">
                <div class="comment-arrow">&#8627;</div>
                <div class="comment-body">
                    <div class="comment-header">
                        <div class="avatar avatar-small" style="background:' . $k_avatar_bg . ';">' . $k_initial . '</div>
                        <span class="username-small">' . $k_username . '</span>
                    </div>
                    <div class="comment-content">' . $k_isi . '</div>
                </div>
            </div>';
        }

        $ownerActionsHtml = '';
        if($isOwner){
            $ownerActionsHtml = '
            <div class="post-owner-actions">
                <button class="btn-edit-post" data-id="' . $post_id . '" title="Edit">&#9999;&#65039;</button>
                <button class="btn-delete-post" data-id="' . $post_id . '" title="Hapus">&#128465;&#65039;</button>
            </div>';
        }

        $html .= '
        <div class="post" data-id="' . $post_id . '" data-raw="' . $post_isi_raw . '">
            ' . $ownerActionsHtml . '
            <div class="post-header">
                <div class="avatar" style="background:' . $post_avatar_bg . ';">' . $post_initial . '</div>
                <div class="post-meta">
                    <span class="username">' . $post_username . '</span>
                    <span class="post-time">' . $waktu . '</span>
                </div>
            </div>
            <div class="post-content">' . $post_isi . '</div>
            <div class="post-actions">
                <button class="btn-like' . ($hasLiked ? ' liked' : '') . '" data-id="' . $post_id . '" ' . ($hasLiked ? 'disabled' : '') . '>
                    <span class="icon-heart">&#10084;&#65039;</span>
                    <span class="like-count">' . $like_count . '</span>
                </button>
                <button class="btn-comment-toggle" data-id="' . $post_id . '">
                    &#128172; Komentar (' . $jumlahKomentar . ')
                </button>
            </div>
            <div class="comment-section" id="comment-section-' . $post_id . '">
                <div class="comment-list">' . $komentarHtml . '</div>
                <div class="comment-input-box">
                    <input type="text" class="comment-input" placeholder="Tulis komentar..." data-id="' . $post_id . '">
                    <button class="btn-send-comment" data-id="' . $post_id . '">Kirim</button>
                </div>
            </div>
        </div>';
    }

    return $html;
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_action'])){
    $action = $_POST['ajax_action'];

    if($action === 'add_post'){
        $isi = trim($_POST['isi'] ?? '');
        if($isi !== ''){
            $stmt = $conn->prepare("INSERT INTO diskusi_post (username, isi) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $isi);
            $stmt->execute();
        }
    }
    elseif($action === 'add_comment'){
        $post_id = (int)($_POST['post_id'] ?? 0);
        $isi     = trim($_POST['isi'] ?? '');
        if($isi !== '' && $post_id > 0){
            $stmt = $conn->prepare("INSERT INTO diskusi_komentar (post_id, username, isi) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $post_id, $username, $isi);
            $stmt->execute();
        }
    }
    elseif($action === 'like_post'){
        $post_id = (int)($_POST['post_id'] ?? 0);
        if($post_id > 0){
            
            $stmtCek = $conn->prepare("SELECT id FROM diskusi_like WHERE post_id = ? AND username = ?");
            $stmtCek->bind_param("is", $post_id, $username);
            $stmtCek->execute();
            $sudahLike = $stmtCek->get_result()->fetch_assoc();

            if(!$sudahLike){
                $stmtInsert = $conn->prepare("INSERT INTO diskusi_like (post_id, username) VALUES (?, ?)");
                $stmtInsert->bind_param("is", $post_id, $username);
                $stmtInsert->execute();

                $stmtUpdate = $conn->prepare("UPDATE diskusi_post SET like_count = like_count + 1 WHERE id = ?");
                $stmtUpdate->bind_param("i", $post_id);
                $stmtUpdate->execute();
            }
            
        }
    }
    elseif($action === 'edit_post'){
        $post_id = (int)($_POST['post_id'] ?? 0);
        $isi     = trim($_POST['isi'] ?? '');
        if($post_id > 0 && $isi !== ''){
            // hanya pemilik post (sesuai session) yang bisa edit
            $stmt = $conn->prepare("UPDATE diskusi_post SET isi = ? WHERE id = ? AND username = ?");
            $stmt->bind_param("sis", $isi, $post_id, $username);
            $stmt->execute();
        }
    }
    elseif($action === 'delete_post'){
        $post_id = (int)($_POST['post_id'] ?? 0);
        if($post_id > 0){
            // hanya pemilik post yang bisa hapus; komentar ikut terhapus (ON DELETE CASCADE)
            $stmt = $conn->prepare("DELETE FROM diskusi_post WHERE id = ? AND username = ?");
            $stmt->bind_param("is", $post_id, $username);
            $stmt->execute();
        }
    }

    echo renderPosts($conn, $username);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PELATIHAN PEMROGRAMAN</title>
     <link rel="stylesheet" href="allboard.css">
     <link rel="stylesheet" href="board4.css">
</head>
<body>
    <?php include("allboard.php"); ?>

    <div class="diskusi-page-wrapper">

        <div class="ask-box">
            <textarea id="post-input" class="ask-input" placeholder="Tanyakan sesuatu +" rows="1"></textarea>
            <button id="btn-send-post" class="btn-kirim">Kirim</button>
        </div>

        <div id="posts-container" class="posts-container">
            <?php echo renderPosts($conn, $username); ?>
        </div>

    </div>

    
    <div id="modal-overlay-delete" class="modal-overlay">
        <div class="modal-box modal-delete">
            <h3 class="modal-title">Hapus Postingan</h3>
            <p class="modal-text">Yakin ingin menghapus postingan ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-actions">
                <button id="btn-cancel-delete" class="btn-modal btn-batal">Batal</button>
                <button id="btn-confirm-delete" class="btn-modal btn-hapus">Hapus</button>
            </div>
        </div>
    </div>

    
    <div id="modal-overlay-edit" class="modal-overlay">
        <div class="modal-box modal-edit">
            <h3 class="modal-title">Edit Postingan</h3>
            <textarea id="edit-textarea" class="modal-textarea" rows="6"></textarea>
            <div class="modal-actions">
                <button id="btn-cancel-edit" class="btn-modal btn-batal">Batal</button>
                <button id="btn-confirm-edit" class="btn-modal btn-simpan">Simpan</button>
            </div>
        </div>
    </div>

    <script>
    const currentOpenComments = new Set();
    const postsContainer = document.getElementById('posts-container');

    function reapplyOpenState(){
        currentOpenComments.forEach(id => {
            const section = document.getElementById('comment-section-' + id);
            if(section) section.classList.add('open');
        });
    }

    async function refreshPosts(formData){
        const res  = await fetch('board4.php', { method: 'POST', body: formData });
        const html = await res.text();
        postsContainer.innerHTML = html;
        reapplyOpenState();
    }

    
    const postInput = document.getElementById('post-input');

    document.getElementById('btn-send-post').addEventListener('click', async () => {
        const isi = postInput.value.trim();
        if(isi === '') return;

        const formData = new FormData();
        formData.append('ajax_action', 'add_post');
        formData.append('isi', isi);

        await refreshPosts(formData);
        postInput.value = '';
        postInput.style.height = 'auto';
    });

   
    postInput.addEventListener('input', () => {
        postInput.style.height = 'auto';
        postInput.style.height = postInput.scrollHeight + 'px';
    });

    
    const deleteOverlay  = document.getElementById('modal-overlay-delete');
    const editOverlay    = document.getElementById('modal-overlay-edit');
    const editTextarea   = document.getElementById('edit-textarea');

    let pendingDeleteId = null;
    let pendingEditId   = null;

    function openDeleteModal(postId){
        pendingDeleteId = postId;
        deleteOverlay.classList.add('show');
    }
    function closeDeleteModal(){
        deleteOverlay.classList.remove('show');
        pendingDeleteId = null;
    }
    function openEditModal(postId, oldText){
        pendingEditId = postId;
        editTextarea.value = oldText;
        editOverlay.classList.add('show');
        editTextarea.focus();
    }
    function closeEditModal(){
        editOverlay.classList.remove('show');
        pendingEditId = null;
    }

    document.getElementById('btn-cancel-delete').addEventListener('click', closeDeleteModal);
    document.getElementById('btn-cancel-edit').addEventListener('click', closeEditModal);

    
    deleteOverlay.addEventListener('click', (e) => { if(e.target === deleteOverlay) closeDeleteModal(); });
    editOverlay.addEventListener('click', (e) => { if(e.target === editOverlay) closeEditModal(); });

    document.getElementById('btn-confirm-delete').addEventListener('click', async () => {
        if(!pendingDeleteId) return;
        const formData = new FormData();
        formData.append('ajax_action', 'delete_post');
        formData.append('post_id', pendingDeleteId);
        await refreshPosts(formData);
        closeDeleteModal();
    });

    document.getElementById('btn-confirm-edit').addEventListener('click', async () => {
        if(!pendingEditId) return;
        const newText = editTextarea.value.trim();
        if(newText === '') return;

        const formData = new FormData();
        formData.append('ajax_action', 'edit_post');
        formData.append('post_id', pendingEditId);
        formData.append('isi', newText);
        await refreshPosts(formData);
        closeEditModal();
    });

    
    postsContainer.addEventListener('click', async (e) => {

       
        const likeBtn = e.target.closest('.btn-like');
        if(likeBtn){
            likeBtn.classList.add('liked-anim');
            const formData = new FormData();
            formData.append('ajax_action', 'like_post');
            formData.append('post_id', likeBtn.dataset.id);
            await refreshPosts(formData);
            return;
        }

        
        const editBtn = e.target.closest('.btn-edit-post');
        if(editBtn){
            const postEl = editBtn.closest('.post');
            openEditModal(editBtn.dataset.id, postEl.dataset.raw);
            return;
        }

        
        const deleteBtn = e.target.closest('.btn-delete-post');
        if(deleteBtn){
            openDeleteModal(deleteBtn.dataset.id);
            return;
        }

        
        const toggleBtn = e.target.closest('.btn-comment-toggle');
        if(toggleBtn){
            const postId  = toggleBtn.dataset.id;
            const section = document.getElementById('comment-section-' + postId);
            if(section.classList.contains('open')){
                section.classList.remove('open');
                currentOpenComments.delete(postId);
            } else {
                section.classList.add('open');
                currentOpenComments.add(postId);
            }
            return;
        }

        
        const sendCommentBtn = e.target.closest('.btn-send-comment');
        if(sendCommentBtn){
            const postId  = sendCommentBtn.dataset.id;
            const inputEl = document.querySelector('.comment-input[data-id="' + postId + '"]');
            const isi     = inputEl.value.trim();
            if(isi === '') return;

            currentOpenComments.add(postId); // tetap terbuka setelah refresh

            const formData = new FormData();
            formData.append('ajax_action', 'add_comment');
            formData.append('post_id', postId);
            formData.append('isi', isi);

            await refreshPosts(formData);
            return;
        }
    });

    
    postsContainer.addEventListener('keypress', (e) => {
        if(e.target.classList.contains('comment-input') && e.key === 'Enter'){
            const btn = document.querySelector('.btn-send-comment[data-id="' + e.target.dataset.id + '"]');
            if(btn) btn.click();
        }
    });
    </script>

</body>
</html>