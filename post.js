// Function to fetch and display posts

const postListElement = document.querySelector('.postList');

function goToPostPage() {
    window.location.href = 'posting.php';
}

async function getPosts() {
    try {
        // Fetch data from the PHP API endpoint
        const response = await fetch('api.php');

        // Check if response is ok
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        // Parse JSON response
        const result = await response.json();

        // Check if request was successful
        if (result.success) {
            const posts = result.data;

            // Check if there are posts
            if (posts.length > 0) {
                // Display each post
                posts.forEach(post => {
                    console.log(`ID: ${post.id}`);
                    console.log(`Title: ${post.title}`);
                    console.log(`Description: ${post.description}`);
                    console.log(`URL: ${post.url}`);
                    console.log('-------------------');

                    // If you want to display in HTML instead of console:
                    const postElement = document.createElement('div');
                    postElement.className = 'post';
                    const imageElement = document.createElement('img');
                    imageElement.src = post.url;
                    imageElement.alt = post.title;
                    imageElement.className = 'post-image';
                    postElement.appendChild(imageElement);
                    postElement.innerHTML =
                        `
                        <div>
                            <p class = "postId">ID: ${post.id}</p>
                            <p class = "postTitle">${post.title}</p>
                            <p class = "postDescripton">${post.description}</p>
                        </div>
                        <div class = "postImage" style="background-image: url(${post.url});"></div>
                    `;
                    // document.body.appendChild(postElement);
                    postListElement.appendChild(postElement);
                });
            } else {
                console.log('No posts found.');
                // Or for HTML: document.body.innerHTML = 'No posts found.';
            }
        } else {
            throw new Error(result.error);
        }

    } catch (error) {
        console.error('Error fetching posts:', error.message);
        // Or for HTML: document.body.innerHTML = `Error: ${error.message}`;
    }
}

// Call the function when the page loads
document.addEventListener('DOMContentLoaded', getPosts);