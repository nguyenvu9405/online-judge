#include <iostream>

using namespace std;

long long s,n;
long long a[100];
void input()
{
    cin >> n;
}
void check()
{
    long long t = 0;
    for (long long i = 1; i <= n; i++)
    {
        if (a[i] == 0) t++; else t--;
        if (t < 0) return;
    }
    if (t == 0) s++;
}
void bk(long long j)
{
    for (long long i = 0; i <= 1; i++)
    {
        if(a[0]>=a[1]&&a[0]<=n/2)
        {   a[j] = i;
            if (j == n) check();
            else bk(j + 1);
        }
    }
}
int main()
{
    input();
    bk(1);
    cout << s;
    return 0;
}
