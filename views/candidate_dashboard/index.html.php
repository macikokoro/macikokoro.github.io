<div class="container">
<div id='content'>
    <ul id="candidateDashoardTab" class="nav nav-tabs">
        <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
        <li class=""><a href="#scorecard" data-toggle="tab">Score Card</a></li>
        <li class=""><a href="#companies" data-toggle="tab">Companies</a></li>
        <li class=""><a href="#meetup" data-toggle="tab">Meetup</a></li>
        <li class=""><a href="#videos" data-toggle="tab">Videos</a></li>
        <li class=""><a href="#calendar" data-toggle="tab">Calendar</a></li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="questions">


            <div >
                <div
                    data-angular-treeview="true"
                    data-tree-id="questions"
                    data-tree-model="treedata"
                    data-node-id="id"
                    data-node-label="label"
                    data-node-children="children"  id="ctrl-question-exmpl" ng-controller="candidateQuestionController">
                </div>
            </div>


        </div>
        <div class="tab-pane fade" id="scorecard">
            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
        </div>
        <div class="tab-pane fade" id="companies">
            <p>
                The syllabus for the interviews is very clear and simple:
                1) Dynamic Programming
                2) Super recursion (permutation, combination,...2^n, m^n, n!...etc. type of program. (NP hard, NP programs)
                3) Probability related programs
                4) Graphs: BFS/DFS are usually enough
                5) All basic data structures from Arrays/Lists to circular queues, BSTs, Hash tables, B-Trees, and Red-Black trees, and all basic algorithms like sorting, binary search, median,...
                6) Problem solving ability at a level similar to TopCoder Division 1, 250 points. If you can consistently solve these, then you are almost sure to get in with 2-weeks brush up.
                7) Review all old interview questions in Glassdoor to get a feel. If you can solve 95% of them at home (including coding them up quickly and testing them out in a debugger + editor setup), you are in good shape.
                8) Practice coding--write often and write a lot. If you can think of a solution, you should be able to code it easily...without much thought.
                9) Very good to have for design interview: distributed systems knowledge and practical experience.
                10) Good understanding of basic discrete math, computer architecture, basic math.
                11) Coursera courses and assignments give a lot of what you need to know.
                12) Note that all the above except the first 2 are useful in "real life" programming too!

            </p>

            <p>
                1. Explain and Write KnapSack Algo with Memorization
                2. Given a undirected graph, clone it. Now if the undirected graph has the neighbors with the nodes as same data - how do you make sure you create the exact same branches and also how do you make sure you don't run into loops for the exact node. He gave a empty directed graph and asked me write code after that.
                3. Given two Btrees. these trees "may" have right and left branches swapped. Now compare it.

                Round 2:
                1. Given a N different open and close braces in a string "( { [ } ] )". How do you check whether the string has matching braces.
                2. Given a unsorted array. Create a balanced BTREE
                3. Print a tree like (Parent ( leftchild (leftchild, rightchild), rightchild(leftchild,rightchild) ) )

                Round 3:
                Given a kernal code in "0"th machine. How soon you can replicate the kernal across N machines. Now if the machines has upload and download bandwidth constraints, how can you impove the copy time.

                Round 4:
                1. Design Short URL.
                2. Given a List with duplicate Strings, how do you remove duplicate Strings

                Round 5:
                1. How do you design a Maze and what kind of data structures you use for Maze.
                2. Now print the shorted path from start to end point.
            </p>

            <p>
                Phone interview
                    * Tri-Tree implementation
            </p>

            <p>
                First question was in-order traversal of BST. I wrote the code. Then asked me two check if two different BSTs have same inorder traversal. I suggested to store first inorder traversal into vector, and while traversing second BST check if the element values match. I also started suggesting using linked list, or modified recursive approach, but he said to make life easy and go with the simple solution.

                Second interviewer gave me array, with elements first strictly increasing, then strictly decreasing. Asked me to find the largest number. I suggested to use binary search. O(logN) time complexity, with no additional space required. After implementing the code he asked another question. Given infinite doubly linked list, and separate list of elements, which are linked to some linked list elements. Find out from the list of elements how many neighboring groups are formed. I suggested to use Hashtable, to make look-up process quick, and traverse the elements and check if they are neighboring elements. O(N) time and space complexity. Implemented the code, and time ran out to test if with different cases.

                Third interview was the weirdest. The guy had thick accent and from the beginning became apparent communication was an issue. He gave me system design question: Observer class has three methods AddObserver(), RemoveObserver(), NotifyAllObservers(). After asking some clarification questions, I suggested to use doubly linked list to keep track of all observers, and hash table to look-up the individual observer. Then he asked to implement three methods. After implementing the code in JAVA he told me the program would not work. Apparently the Observer was designed for Chrome browser. He went into details when user clicks on mouse and then key-press is released. I responded the initial question was very vague and asked for more clarification and precise requirements. I suggested what I would change to go around the problem, but time ran out and didn't get a chance to modify the code on whiteboard.

                After that I had lunch and came back for fourth technical interview.
                Fourth interview: the guy told me to add two numbers in base 3 system. The input: two base 3 streams provided as String. function should return sum of the two numbers also in String format as base 3 stream. I suggested to convert from base 3 into base 10, add numbers and convert back to base 3. I know how to add two (base 2) binary streams without conversion, since I was under the time pressure I went easy way. I implemented conversion from base 3 to base 10. The interviewer said he was satisfied and wanted me to solve another problem. He gave me file size, and asked me to partition file into chunks, so that each chunk size is power of two, and the number of chunks is minimal. I suggested to find the nearest power of two and obtain absolute value of difference between the original file size, and nearest power of two. Then re-apply the process until reminder is power of two (1 is 2^0). There was time pressure, so didn't have time for analysis, just implemented and turned in the code.

            </p>

            <p>
                Interview Question – Build a pseudorandom maze. Write a method to deep copy a graph. Given an n x n matrix of numbers, how do I find a number?
            </p>

            <p>
                A few notes:

                Take your time, don't be afraid to ask for a later interview date to study up. I went over Cracking the Coding Interview by Gayle, its a good book to review basic concepts. No questions I got actually came out of the book, but its good mental prep for the kind of problems you'll face.

                Also try top coder to work on coding if you are out of date writing actual code. I feel top coder questions are a bit brute force compared to the questions you'll get. Top coder questions ask you to accomplish a task, but the extent of what you'll end up using is arrays and strings. You won't get good coverage of things like trees, linked lists, etcs.

                Don't assume you'll need to get everything right during interviews. I didn't for sure and one interviewer had a distinctly negative attitude (whether this was intended or he actually flunked me I don't know), but I still ended up doing well enough to pass. Also, don't worry about the interviewers typing or writing during the interview. Apparently, they need to take all of your code verbatim to give to the hiring committee, so however much you write, they need to write. Stay calm and talk through your answers. Don't assume you did poorly or well, its too hard to guess and treat each interviewer individually.

                Overall a long process, but a fair one. In engineering its important to keep standards high and consistent.


            </p>
        </div>
        <div class="tab-pane fade" id="meetup">
            <p>

            </p>
        </div>
        <div class="tab-pane fade" id="videos">
            <p>
                <iframe src="http://www.meetup.com/techinterviews/"  style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
            </p>
        </div>
        <div class="tab-pane fade" id="calendar">
            <p>
                <iframe src="https://www.google.com/calendar/embed?src=v8579or2pt03pb50ii9a7jvedk%40group.calendar.google.com&ctz=America/Los_Angeles" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
            </p>
        </div>


    </div>

</div>
</div>