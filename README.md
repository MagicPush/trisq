[По-русски 🇷🇺](README_RU.md)

# The "Trisq" game

## About the project

We want to develop a new game called "Trisq" (triangles and squares).

For now, it should be a stateless CLI-based application.
- Arguments specified for the program (`play.php`) are meant to be players' moves:
  `player1_move player2_move player1_move player2_move ...`
- Players' moves are based on the european coordinates style ("A1"). Do note that such a style excludes `i` column
  (`j` goes right after `h`) to prevent ambiguity in perceiving symbols looking similar to `i`.
- The application should reflect the board state according to the moves done and the rules implemented.

Example:
```
$ php play.php a13 c12
   a  b  c  d  e  f  g  h  j  k  l  m  n
13 ▲  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
12 ·  ·  □  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
11 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
10 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 9 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 8 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 7 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 6 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 5 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 4 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 3 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 2 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
 1 ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·  ·
```

You need to modify the project by implementing the logic requested in the tasks below.

## Task 1

Implement the core placement mechanics:
1. Initially the board is empty.
2. Triangles go first.
3. Each player places one figure per move. The next move should be done by another player (figure type).
4. A figure may not be placed on top of / instead of another already placed figure. Throw an exception in this case.
5. Reflect moves on the board - show the correct board state in a console.

Verify your code when you complete the task:
```shell
./phpunit.phar --group=task1
```

## Task 2

Implement capture mechanics:
1. A simplified capture: remove (capture) a single enemy figure if such a figure is surrounded vertically
   and horizontally by a current player figures or the board walls.
    * Do not bother with capturing a chain of same figures at once.
      For this task you always need to capture a single figure only.

    ```
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
     ·  ·  ▲  ·  ·       ·  ·  ▲  ·  ·       ·  ·  ▲  ·  · 
     ·  ▲  □  ·  ·       ·  ▲  □  ▲  ·       ·  ▲  ·  ▲  · 
     ·  ·  ▲  ·  ·       ·  ·  ▲  ·  ·       ·  ·  ▲  ·  · 
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
        Before           Triangle added      Square captured
    ```

    ```
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
     □  ·  ·  ·  ·       □  ·  ·  ·  ·       □  ·  ·  ·  · 
     ▲  □  ·  ·  ·       ▲  □  ·  ·  ·       ·  □  ·  ·  · 
     ·  ·  ·  ·  ·       □  ·  ·  ·  ·       □  ·  ·  ·  · 
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
        Before           Square added      Triangle captured
    ```
2. Prohibit self-capture: throw an exception for the move when a just placed figure would be immediately captured
   by a surrounding enemy figures or the board walls.
   
   Do note, that capture of an enemy takes precedence over self-capture.

    ```
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
     ·  ·  ▲  ·  ·       ·  ·  ▲  ·  ·       ·  ·  ▲  ·  · 
     ·  ▲  ·  ▲  ·       ·  ▲  □  ▲  ·       ·  ▲  ·  ▲  · 
     ·  ·  ▲  ·  ·       ·  ·  ▲  ·  ·       ·  ·  ▲  ·  · 
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
        Before           Square added       Square captured
    ```
3. Prohibit the immediate repetition of a board state - to ensure no endless capture loop possible.

   A play is illegal if it would create a board with the same figures on the same locations as a couple of moves before
   (the same state for the same player):

    ```
     ·  ·  ·  ·  ·       ·  ·  ·  ·  ·       ·  ·  ·  ·  · 
     ·  ▲  ▲  ·  ·       ·  ▲  ▲  ·  ·       ·  ▲  ▲  ·  · 
     ·  ·  □  ·  ·       ·  ·  □  ·  ·       ·  ·  □  ·  · 
     ·  ·  ·  □  ▲       ·  ·  ·  □  ▲       ·  ·  ·  □  ▲ 
     ·  ·  □  ▲  ·       ·  ·  □  ·  □       ·  ·  □  ▲  · 
        Before         Triangle captured     Square captured
                                                    ^
                                                    |
                                  Illegal state: the same state as "Before".
                              This way players may capture each other endlessly.
    ```

Verify your code when you complete the task:
```shell
./phpunit.phar --group=task2
```
